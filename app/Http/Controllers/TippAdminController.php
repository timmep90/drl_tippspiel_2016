<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\ManageTippRequest;
use App\Library\DBOpenLigaConnector;
use App\Setting;
use App\UserGroup;
use Illuminate\Http\Request;

class TippAdminController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('registered');
        $this->middleware('groupAdmin');
    }

    /* Function to manage User of specific groups */
    public function manage($id)
    {
        $settings = Group::find($id);
        $users = UserGroup::with('user')->where('group_id', $id)
            ->orderBy('created_at', 'asc')->paginate(15);
        return view('tippspiel.manage', compact('users', 'settings'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manageUpdate($id, ManageTippRequest $request)
    {
        $ugs = UserGroup::where('group_id', '=', $id)->get();
        $settings = Group::find($id);

        $settings->update(['kt_points'=>$request->kt_points, 'tt_points' => $request->tt_points,
        'st_points' => $request->st_points, 'm_points' => $request->m_points]);

        foreach($ugs as $ug) {
            $isAdmin = 0; $pending = 1;
            if (isset($request->isAdmin_user[$ug->id]))
                $isAdmin = 1;
            if(!isset($request->pending_user[$ug->id]))
                $pending = 0;

            $ug->isAdmin = $isAdmin;
            $ug->pending = $pending;
            $ug->save();
        }
        updateMatches($id);

        $users = UserGroup::with('user')->where('group_id', $id)
            ->orderBy('created_at', 'asc')->paginate(15);
        return view('tippspiel.manage', compact('users', 'settings'));
    }


}
