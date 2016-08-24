<?php

/*
 * Taken from
 * https://github.com/laravel/framework/blob/5.2/src/Illuminate/Auth/Console/stubs/make/controllers/HomeController.stub
 */

namespace App\Http\Controllers;

use App\Group;
use App\League;
use App\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('registered');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $groups = Group::with('group_user', 'league')->active()->get();
        return view('home', compact('groups'));
    }

    public function joinGroup(Request $request)
    {
        $league_id = League::findGroup($request->id)->id;

        if(UserGroup::where('user_id', Auth::user()->id)->where('group_id', $request->id)->first() === null)
            UserGroup::create(['user_id' => Auth::user()->id, 'pending' => 0, 'isAdmin' => false, 'group_id' => $request->id]);

        createBetsFor(Auth::user()->id, $request->id,$league_id);

        $groups = Group::active()->get();
        return view('home', compact('groups'));
    }
}