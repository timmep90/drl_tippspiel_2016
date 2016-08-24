<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    protected $table = 'group_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'kt', 'tt', 'st', 'm', 'points', 'user_id', 'group_id', 'pending','isAdmin',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function match_tips()
    {
        return $this->hasMany('App\MatchTip');
    }

}
