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
        'type', 'club_nr1', 'club_nr2', 'erg1', 'erg2', 'match_datetime', 'matchday', 'ext_id'
    ];

    public function scopeWhereGroup($query, $id){
        return $query->whereHas('match_tips', function($query) use ($id){
            $query->where('group_id', $id);
        });
    }

    public function match_tips()
    {
        return $this->hasMany('App\MatchTip');
    }


    public function club1()
    {
        return $this->belongsTo('App\Club', 'club1_nr');
    }

    public function club2()
    {
        return $this->belongsTo('App\Club', 'club2_nr');
    }

    public function groups()
    {
        return $this->hasMany('App\Group')->withTimestamps();
    }


}
