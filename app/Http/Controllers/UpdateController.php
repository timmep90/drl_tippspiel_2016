<?php

namespace App\Http\Controllers;

use App\League;
use App\Match;
use App\MatchTip;
use App\Team;
use Grambas\FootballData\Facades\FootballDataFacade;
use Illuminate\Http\Request;

use App\Http\Requests;

class UpdateController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function update(Request $request)
    {

        $resource = $request->json()->get('Resource');
        $id = $request->json()->get('Id');

        if($resource == "Competition"){
            $league_id = League::fetchLeagues()->where('ext_id', $id)->first()->id;

            $teams = json_decode(FootballDataFacade::getLeagueTeams($id))->teams;

            foreach ($teams as $team) {

                Team::updateOrCreate(['name' => $team->name],
                    ['shortcut' => $team->code, 'logo' => $team->crestUrl, 'short_name' => $team->shortName])
                    ->leagues()->sync([$league_id]);
            }

            return response('Competition data created.', 201);

        } else {
            /* $match = json_decode(FootballDataFacade::getFixture($id));

            $id = after_last('/', $match->fixture->_links->competition->href);


            if($league === null){
                return response('Received', 200);
            } */
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
                        'matchday'=>$match->matchday, 'date'=>\Carbon\Carbon::parse($match->date)->addHours(2), 'status' => $match->status]);
            }

            return response('Fixture data created.', 201);
        } /*else {
            return response($resource.'<= unknown' ,501);
        } */

    }
}
