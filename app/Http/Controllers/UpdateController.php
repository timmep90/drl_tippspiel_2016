<?php

namespace App\Http\Controllers;

use App\Match;
use Illuminate\Http\Request;

use App\Http\Requests;

class UpdateController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $content = $request->getContent();
        if ($content->Resource == "Competition")
            Match::first()->update(['home_team_erg'=>10]);
    }
}
