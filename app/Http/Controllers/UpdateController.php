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

        if ($request->ip()){
            $resource = $request->json()->get('Resource');
            $id = $request->json()->get('Id');

            if ($resource == "Competition") {
                Log::info('Competition Info:' . $request);

                $league_id = League::fetchLeagues()->where('ext_id', $id)->first()->id;

                $teams = json_decode(FootballDataFacade::getLeagueTeams($id))->teams;

                foreach ($teams as $team) {

                    Team::updateOrCreate(['name' => $team->name],
                        ['shortcut' => $team->code, 'logo' => $team->crestUrl, 'short_name' => $team->shortName])
                        ->leagues()->sync([$league_id]);
                }

                Log::info('Competition info:' . $request);

                return response('Competition data created.', 201);

            } else if ($resource == "Fixture") {
                if ($request->json()->get("Updates")) {
                    $update = json_decode($request->json()->get('Updates'));
                    $match = Match::where('ext_id', $id)->first();
                    if ($match) {
                        if(!($match->status == "FINISHED")){
                            $match->home_team_erg = (array_key_exists('goalsHomeTeam', $update) ? $update->goalsHomeTeam[1] : $match->home_team_erg);
                            $match->vis_team_erg = (array_key_exists('goalsAwayTeam', $update) ? $update->goalsAwayTeam[1] : $match->vis_team_erg);
                            $match->date = (array_key_exists('dateTime', $update) ? \Carbon\Carbon::parse($update->dateTime[1])->addHours(2) : $match->date);
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
                } else {
                    Log::info('No update:' . $request);
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
        /* else {
            // $match = json_decode(FootballDataFacade::getFixture($id));

            //$id = after_last('/', $match->fixture->_links->competition->href);


            //if($league === null){
            //    return response('Received', 200);
            //}

            Log::info('Request info: '.$request);

            $league = \App\League::where('ext_id', 430)->first();

            $matches = json_decode(FootballDataFacade::getLeagueFixtures(430))->fixtures;

            $teams = \App\Team::whereHas('leagues', function ($query) use ($league){
                return $query->where('leagues.id', $league->id);
            })->get();


            foreach ($matches as $match){
                $homeTeam = $teams->where('name', $match->homeTeamName)->first()->id;
                $visitingTeam = $teams->where('name', $match->awayTeamName)->first()->id;

                \App\Match::updateOrCreate(['league_id'=>$league->id, 'home_team_id'=>$homeTeam, 'vis_team_id'=>$visitingTeam],
                    ['home_team_erg'=>$match->result->goalsHomeTeam, 'vis_team_erg'=>$match->result->goalsAwayTeam,
                        'matchday'=>$match->matchday, 'date'=>\Carbon\Carbon::parse($match->date)->addHours(2), 'status' => $match->status,
                        'ext_id'=>after_last('/', $match->_links->self->href)]);
            }

            return response('Fixture data created.', 201);
        }  else {
            return response($resource.'<= unknown' ,501);
        } */

    }
}
