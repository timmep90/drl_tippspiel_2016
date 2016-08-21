<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'match_type_id','year', 'isActive',
    ];

    public function scopeActive($query){
        return $query->where('isActive', true);
    }

    public function user_group()
    {
        return $this->hasMany('App\UserGroup');
    }

    public function setting()
    {
        return $this->hasOne('App\Setting');
    }

    public function match_type()
    {
        return $this->belongsTo('App\MatchType');
    }

    public function matches_tips()
    {
        return $this->hasMany('App\MatchTip');
    }

    public function matches()
    {
        return $this->belongsTo('App\Match')->withTimestamps();
    }
}
