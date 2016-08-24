<?php

function createBetsFor($user, $group, $league)
{
    $matches = \App\Match::where('league_id', $league)->get();
    $group_user = \App\UserGroup::where([['user_id', $user],['group_id', $group]])->first();
    $match_tips = \App\MatchTip::where('group_user_id', $group_user->id)->get();

    foreach ($matches as $match) {
        \App\MatchTip::create(['group_user_id' => $group_user->id, 'match_id' => $match->id]);
    }
}

function calcAndSavePoints($id){

    $settings = \App\Group::find($id);
    $group_user = \App\UserGroup::where('group_id', $id)->get();

    $matches_tips = \App\MatchTip::with('group_user', 'match')->FinishedMatches()->whereHas('group_user', function($query) use ($id){
            return $query->where('group_id', $id);
        })->get();

    foreach($group_user as $ug){
        $mts = $matches_tips->where('group_user_id',$ug->id);
        $kt = 0; $tt = 0; $st = 0; $m = 0;
        foreach($mts as $mt){
            $t1 = $mt->t1; $t2 = $mt->t2;
            $erg1 = $mt->match->erg1; $erg2 = $mt->match->erg2;
            if($t1 === null || $t2 === null)
                $m++;
            else if($t1 == $erg1 && $t2 == $erg2)
                $kt++;
            else if(($t1 - $t2) == ($erg1 - $erg2))
                $tt++;
            else if((($t1 > $t2) && ($erg1 > $erg2)) || (($t1 < $t2) && ($erg1 < $erg2)))
                $st++;
            else
                $m++;

        }
        $pts = $kt * $settings->kt_points + $tt * $settings->tt_points + $st * $settings->st_points
            + $m * $settings->m_points;
        $ug->update(['kt' => $kt, 'tt' => $tt, 'st' => $st, 'm' => $m, 'points' => $pts]);
    }
    return $group_user->sortByDesc('points');
}

