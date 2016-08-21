<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatchType extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'shortcut',
        'name',
        'year'
    ];

    public function group()
    {
        return $this->hasMany('App\Group');
    }
}
