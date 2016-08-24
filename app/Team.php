<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'short_name', 'shortcut', 'logo',
    ];

    public function matches()
    {
        return $this->hasMany('App\Match');
    }

    public function leagues()
    {
        return $this->belongsToMany('App\League');
    }

}
