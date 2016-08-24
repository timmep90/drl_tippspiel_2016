<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_type_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function scopeWhereGroup($query, $id){

        return $query->whereHas('user_group', function($query) use ($id){
            $query->where('group_id', $id);
        });
    }

    public function user_type()
    {
        return $this->belongsTo('App\UserType');
    }

    public function group_user()
    {
        return $this->hasMany('App\UserGroup');
    }

}
