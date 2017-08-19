<?php

namespace App\Http\Controllers;

use App\League;
use App\Match;
use App\MatchTip;
use App\Team;
use Grambas\FootballData\Facades\FootballDataFacade;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Log;

class UpdateController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function update(Request $request)
    {

        if ($request->ip() == "83.169.21.147"){
            $resource = $request->json()->get('Resource');
            $id = $request->json()->get('Id');

            if ($resource == "Competition") {
                Log::info('Competition info:' . $request);
                return response('Competition data created.', 201);

            } else if ($resource == "Fixture") {
                Log::info('Update!?:' . $request->json());
                if ($request->json()->get("Updates")) {
                    $update = json_decode($request->json()->get('Updates'));
                    $match = Match::where('ext_id', $id)->first();
                    if ($match) {
                        if(!($match->status == "FINISHED")){
                            $match->home_team_erg = (array_key_exists('goalsHomeTeam', $update) ? $update->goalsHomeTeam[1] : $match->home_team_erg);
                            $match->vis_team_erg = (array_key_exists('goalsAwayTeam', $update) ? $update->goalsAwayTeam[1] : $match->vis_team_erg);
                            if($match->status == "SCHEDULED")
                                $match->date = (array_key_exists('dateTime', $update) ? \Carbon\Carbon::parse($update->dateTime[1])->addHours(1) : $match->date);
                            $match->status = (array_key_exists('status', $update) ? $update->status[1] : $match->status);
                            $match->save();
                        } else {
                            Log::info('Change on finished match: ' . $request);
                        }
                    }
                    if (!(array_key_exists('goalsHomeTeam', $update) || array_key_exists('goalsAwayTeam', $update)
                        || array_key_exists('dateTime', $update) || array_key_exists('status', $update))) {
                        Log::info('No known update' . $request);
                    }

                    return response('Fixture data created.', 201);
                }
                return response('Fixture data received.', 200);
            } else {
                Log::info('Type not known:' . $request);
                return response('data received.', 200);
            }
        } else {
            Log::info('Client IP unknown:' . $request->ip());
            return response('data received.', 200);
        }

    }
}
