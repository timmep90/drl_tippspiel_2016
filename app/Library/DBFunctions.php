<?php

function createBetsFor($user, $group)
{
    $matches = \App\Match::get();
    $matches_tips = \App\MatchTip::where('user_id', $user)->get();
    $isCreated = false;

    foreach ($matches as $match) {
        if ($matches_tips->where('match_id', $match->id)->isEmpty()) {
            \App\MatchTip::create(['user_id' => $user, 'match_id' => $match->id, 'group_id' => $group]);
            $isCreated = true;
        }
    }
    if (!$isCreated){
        foreach ($matches as $match) {
            if ($matches_tips->where('group_id', $group)->isEmpty()) {
                \App\MatchTip::create(['user_id' => $user, 'match_id' => $match->id, 'group_id' => $group]);
            }
        }
    }
}

function calcAndSavePoints($id){

    $settings = \App\Setting::where('group_id', $id)->first();
    $user_groups = \App\UserGroup::where('group_id', $id)->get();
    $matches_tips = \App\MatchTip::with('user', 'match')->FinishedMatches()->where('group_id', $id)->get();
    foreach($user_groups as $ug){
        $mts = $matches_tips->where('user_id',$ug->user_id);
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
    return $user_groups->sortByDesc('points');
}

