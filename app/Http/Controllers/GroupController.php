<?php

namespace App\Http\Controllers;

use App\Group;
use App\Library\DBOpenLigaConnector;
use App\Match;
use App\MatchTip;
use App\MatchType;
use App\Setting;
use App\User;
use App\UserGroup;
use Illuminate\Http\Request;

use App\Http\Requests;

class GroupController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('registered');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::with('match_type')->get();
        return view('admin.group', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $openliga = new DBOpenLigaConnector();
        $openliga->updateFootballTypes();

        $match_type_list = MatchType::pluck('name','shortcut');
        $users = User::pluck('name', 'id');
        return view('admin.group.create', compact('users', 'match_type_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->request->add(['match_type_id' => MatchType::where('shortcut', $request->match_type)->first()->id]);
        $request->request->add(['isActive' => isChecked($request->isActive)]);

        $group = Group::create($request->all());

        $openliga = new DBOpenLigaConnector();
        $openliga->updateOpenLigaDataByGroup($group->id);

        UserGroup::create(['user_id' => $request->admin, 'group_id' => $group->id, 'isAdmin' => true, 'pending' => false]);
        Setting::create(['kt_points' => 3, 'tt_points' => 2, 'st_points' => 1, 'm_points' => 0, 'group_id' => $group->id]);

        createBetsFor($request->admin, $group->id);

        $groups = Group::with('match_type')->get();
        return view('admin.group', compact('groups'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $groups = Group::with('match_type')->get();
        return view('admin.group', compact('groups'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::with('match_type','user_group')->find($id);
        $match_type_list = MatchType::pluck('name','shortcut');
        $users = User::pluck('name', 'id');
        return view('admin.group.edit', compact('group', 'users', 'match_type_list'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->request->add(['isActive' => isChecked($request->isActive)]);

        Group::find($id)->update($request->all());

        $groups = Group::with('match_type')->get();
        return view('admin.group', compact('groups'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $groups = Group::with('match_type')->get();
        return view('admin.group', compact('groups'));
    }

    public function destroyFast(Request $request)
    {
        Setting::where('group_id', $request->id)->delete();
        UserGroup::where('group_id', $request->id)->delete();
        MatchTip::where('group_id', $request->id)->delete();
        Group::find($request->id)->delete();

        $groups = Group::with('match_type')->get();
        return view('admin.group', compact('groups'));
    }
}
