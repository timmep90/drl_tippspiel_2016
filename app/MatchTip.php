<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MatchTip extends Model
{
    protected $table = "match_tips";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'points', 'points', 'home_team_bet', 'vis_team_bet', 'match_id',  'group_user_id'
    ];

    public function scopeWhereMatchday($query, $matchday){
        return $query->whereHas('match', function($query) use ($matchday){
            $query->where('matchday', $matchday)->orderBy('date');
        });
    }

    public function scopeWhereGroup($query, $id){
        return $query->whereHas('group_user', function($query) use ($id){
           return $query->where('group_id', $id);
        });
    }

    public function scopeWhereUser($query, $id){
        return $query->whereHas('group_user', function($query) use ($id){
            return $query->where('user_id', $id);
        });
    }

    public function scopeFinishedMatches($query){
        return $query->whereHas('match', function($query){
            $query->where('date', '<', Carbon::now())->orderBy('date');
        });
    }

    public function scopeWhereExtId($query, $id){
        return $query->whereHas('match', function($query) use ($id){
           $query->where('ext_id', $id);
        });
    }

    public function scopeAuthUser($query){
        return $query->whereHas('group_user', function($query){
            return $query->where('user_id', Auth::user()->id);
        });
    }

    public function match()
    {
        return $this->belongsTo('App\Match');
    }

    public function group_user()
    {
        return $this->belongsTo('App\UserGroup');
    }

}
