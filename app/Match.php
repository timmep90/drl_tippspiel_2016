<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    protected $dates = ['created_at', 'updated_at', 'match_datetime'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'home_team_id', 'vis_team_id', 'home_team_erg', 'vis_team_erg', 'date', 'matchday', 'ext_id',
        'league_id', 'status'
    ];


    public function match_tips()
    {
        return $this->hasMany('App\MatchTip');
    }


    public function home_team()
    {
        return $this->belongsTo('App\Team', 'home_team_id');
    }

    public function vis_team()
    {
        return $this->belongsTo('App\Team', 'vis_team_id');
    }

    public function league()
    {
        return $this->belongsTo('App\League');
    }

}
