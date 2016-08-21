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