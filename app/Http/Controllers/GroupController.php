<?php

namespace App\Http\Controllers;

use App\Group;
use App\League;
use App\Library\DBOpenLigaConnector;
use App\Match;
use App\MatchTip;
use App\MatchType;
use App\Setting;
use App\Team;
use App\User;
use App\UserGroup;
use Carbon\Carbon;
use Grambas\FootballData\Facades\FootballDataFacade;
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
        $groups = Group::with('league')->get();
        return view('admin.group', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $leagues = League::pluck('name', 'ext_id');
        $users = User::pluck('name', 'id');
        return view('admin.group.create', compact('users', 'leagues'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $league_id = League::where('ext_id', $request->league)->first()->id;
        $request->request->add(['league_id' => $league_id]);
        $request->request->add(['isActive' => isChecked($request->isActive)]);
        $request->request->add(['kt_points' => 3, 'tt_points' => 2, 'st_points' => 1, 'm_points' => 0]);

        $teams = json_decode(FootballDataFacade::getLeagueTeams($request->league))->teams;

        foreach ($teams as $team){
            Team::updateOrCreate(['name'=>$team->name],
                ['shortcut'=>$team->code, 'logo'=>$team->crestUrl, 'short_name'=>$team->shortName])
                ->leagues()->sync([$league_id]);
        }

        $group = Group::create($request->all());

        updateMatches($group->id);

        UserGroup::create(['user_id' => $request->admin, 'group_id' => $group->id, 'isAdmin' => true, 'pending' => false]);

        createBetsFor($request->admin, $group->id, $league_id);

        $groups = Group::with('league')->get();
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

        $groups = Group::with('league')->get();
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
        $group = Group::with('league','group_user')->find($id);
        $leagues = League::pluck('name','shortcut');
        $users = User::pluck('name', 'id');
        return view('admin.group.edit', compact('group', 'users', 'leagues'));
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

        $groups = Group::with('league')->get();
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
        $groups = Group::with('league')->get();
        return view('admin.group', compact('groups'));
    }

    public function destroyFast(Request $request)
    {
        UserGroup::where('group_id', $request->id)->delete();
        MatchTip::where('group_id', $request->id)->delete();
        Group::find($request->id)->delete();

        $groups = Group::with('league')->get();
        return view('admin.group', compact('groups'));
    }
}
