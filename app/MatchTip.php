<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MatchTip extends Model
{
    protected $table = "matches_tips";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'points', 't1', 't2', 'user_id', 'match_id', 'group_id'
    ];

    public function scopeWhereMatchday($query, $matchday){
        return $query->whereHas('match', function($query) use ($matchday){
            $query->where('matchday', $matchday)->orderBy('match_datetime');
        });
    }


    public function scopeFinishedMatches($query){
        return $query->whereHas('match', function($query){
            $query->where('match_datetime', '<', Carbon::now())->orderBy('match_datetime');
        });
    }

    public function scopeWhereExtId($query, $id){
        return $query->whereHas('match', function($query) use ($id){
           $query->where('ext_id', $id);
        });
    }

    public function scopeAuthUser($query){
        return $query->where('user_id', Auth::user()->id);
    }

    public function match()
    {
        return $this->belongsTo('App\Match');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

}
