<?php

function flash($message, $level = 'alert-success'){
    session()->flash('flash_message', $message);
    session()->flash('flash_message_level', $level);

}

function checkActive($path){
    return (Request::is($path) ? 'active' : '');
}

function isChecked($value){
    if($value === null)
        return false;
    else
        return true;
}

function calcMatchPoints($matchTip){
    $t1 = $matchTip->t1; $t2 = $matchTip->t2;
    $erg1 = $matchTip->match->erg1; $erg2 = $matchTip->match->erg2;
    if($t1 === null || $t2 === null)
        $points = 0;
    else if($t1 == $erg1 && $t2 == $erg2)
        $points = 5;
    else if(($t1 - $t2) == ($erg1 - $erg2))
        $points = 4;
    else if((($t1 > $t2) && ($erg1 > $erg2)) || (($t1 < $t2) && ($erg1 < $erg2)))
        $points = 3;
    else
        $points = 0;
    return $points;
}

/**
 * Function to set current Page for Match Overview (Pagination).
 * Returns next Page for next Match day if $currentPage is empty.
 *
 * @param $request
 * @return int
 */
function setActivePage($currentPage, $id){

    if($currentPage === null) {
        $group = \App\Group::find($id);
        $currentPage = $group->league->current_matchday;
    }

    \Illuminate\Pagination\Paginator::currentPageResolver(function () use ($currentPage) {
        return $currentPage;
    });
    return $currentPage;
}


function updateMatches($group_id){
    $league = \App\League::findGroup($group_id);

    $matches = json_decode(FootballDataFacade::getLeagueFixtures($league->ext_id))->fixtures;

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
}
