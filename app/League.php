<?php

namespace App;

use Grambas\FootballData\Facades\FootballDataFacade;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ext_id',
        'shortcut',
        'name',
        'year',
        'current_matchday',
    ];

    /* Fetching Data from API and updating DB */
    public function scopeFetchLeagues($query){
        $leagues = json_decode(FootballDataFacade::getLeagues());

        foreach($leagues as $league){
            $this->updateOrCreate(['name' => $league->caption, 'year' => $league->year],
                ['ext_id' => $league->id, 'current_matchday' => $league->currentMatchday,
                    'shortcut' => $league->league]);
        }
        return $query;
    }

    public function scopeFindGroup($query, $id){
        return $query->whereHas('groups', function($query) use ($id){
            return $query->where('id', $id);
        })->get()->first();
    }

    public function teams()
    {
        return $this->belongsToMany('App\Team');
    }

    public function groups()
    {
        return $this->hasMany('App\Group');
    }

    public function matches()
    {
        return $this->hasMany('App\Match');
    }
}
