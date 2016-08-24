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
        'name', 'league_id', 'isActive', 'kt_points', 'tt_points', 'st_points', 'm_points'
    ];

    public function scopeActive($query){
        return $query->where('isActive', true);
    }

    public function group_user()
    {
        return $this->hasMany('App\UserGroup');
    }

    public function league()
    {
        return $this->belongsTo('App\League');
    }
}
