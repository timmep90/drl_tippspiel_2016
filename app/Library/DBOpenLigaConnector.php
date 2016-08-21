<?php

namespace app\Library;

use Andinger\OpenLigaDbApi\Client;
use App\Club;
use App\Group;
use App\Match;
use App\MatchType;


class DBOpenLigaConnector
{

    protected $client;

    public function __construct()
    {
        $this->client = app(Client::class);
    }

    public function updateOpenLigaDataByGroup($group_id){
        $groups = Group::with('match_type')->find($group_id);

        if($groups->match_type->created_at == $groups->match_type->updated_at)
            $last_db_update = null;
        else
            $last_db_update = $groups->match_type->updated_at;

        $updated = false;

        $lastMatchDay = array_slice($this->client->getAvailableGroups($groups->match_type->shortcut, $groups->year), -1)[0]
            ->getOrderID();
        /* Check if any updates are available */
        if($this->client->getLastUpdateByLeagueSeason($groups->match_type->shortcut, $groups->year)>$last_db_update) {



            /* Fetch data from db for comparation and updates */
            $clubs = Club::all();
            $match_list = Match::get();
            $isUpdatingClubs = true;
            /* Iterate through all possible matchdays */
            for ($matchDay = 1; $matchDay<$lastMatchDay+1; $matchDay++) {
                /* Check if there is any update to this specific matchdate */
                if ($this->client->getLastUpdateByGroupLeagueSeason($matchDay, $groups->match_type->shortcut, $groups->year) > $last_db_update) {

                    $matches = $this->client->getMatchesByGroupLeagueSeason($matchDay, $groups->match_type->shortcut, $groups->year);
                    foreach ($matches as $match) {
                        if ($match->getGroupOrderID() != 1 && $isUpdatingClubs == true) {
                            $clubs = Club::all();
                            $isUpdatingClubs = false;
                        }

                        $club1 = $clubs->where('name', $match->getTeam1()->getName())->first();
                        $club2 = $clubs->where('name', $match->getTeam2()->getName())->first();

                        if ($match->getGroupOrderID() == 1) {
                            if ($club1 === null)
                                $club1 = new Club;
                            $club1->name = $match->getTeam1()->getName();
                            $club1->logo = $match->getIconUrlTeam1();
                            $club1->save();

                            if ($club2 === null)
                                $club2 = new Club;
                            $club2->name = $match->getTeam2()->getName();
                            $club2->logo = $match->getIconUrlTeam2();
                            $club2->save();
                        }

                        if ($match->getGoals() && is_array($match->getGoals())){
                            $score1 = array_slice($match->getGoals(), -1)[0]->getScoreTeam1();
                            $score2 = array_slice($match->getGoals(), -1)[0]->getScoreTeam2();
                        } else if ($match->getGoals()) {
                            $score1 = $match->getGoals()->getScoreTeam1();
                            $score2 = $match->getGoals()->getScoreTeam2();
                        }else {
                            $score1 = 0;
                            $score2 = 0;
                        }

                        $db_match = $match_list->where('ext_id', $match->getId())->first();
                        if ($db_match === null)
                            $db_match = new Match();
                        $db_match->ext_id = $match->getId();
                        $db_match->match_datetime = $match->getDateTime()->format('Y-m-d H:i:s');
                        $db_match->matchday = $match->getGroupOrderID();
                        $db_match->club1_nr = $club1->id;
                        $db_match->club2_nr = $club2->id;
                        $db_match->erg1 = $score1;
                        $db_match->erg2 = $score2;
                        $db_match->save();
                    }
                }
            }
            $groups->match_type->touch();

            $updated = true;
        }
        return $updated;
    }

    public function updateFootballTypes(){
        $leagues = $this->client->getAvailableLeaguesBySport(1);
        foreach($leagues as $league)
            if($mt = MatchType::where('shortcut', $league->getShortcut())->where('year', $league->getSeason())->first() === null)
                MatchType::create(['shortcut' => $league->getShortcut(), 'year' => $league->getSeason(), 'name' => $league->getName()]);

    }

    public function initOpenLigaDataByGroup($group_id){
        $groups = Group::with('match_type')->where('id', $group_id)->first();

        if($this->client->getLastUpdateByLeagueSeason($groups->match_type->shortcut, $groups->year)>$groups->match_type->created_at) {
            $isUpdatingClubs = true;
            $clubs = Club::all();
            $match_list = Match::get();

            $matches = $this->client->getMatchesByLeagueSeason($groups->match_type->shortcut, $groups->year);

            foreach ($matches as $match) {
                if ($match->getGroupOrderID() != 1 && $isUpdatingClubs == true) {
                    $clubs = Club::all();
                    $isUpdatingClubs = false;
                }

                $club1 = $clubs->where('name', $match->getTeam1()->getName())->first();
                $club2 = $clubs->where('name', $match->getTeam2()->getName())->first();

                if ($match->getGroupOrderID() == 1) {
                    if ($club1 === null)
                        $club1 = new Club;
                    $club1->name = $match->getTeam1()->getName();
                    $club1->logo = $match->getIconUrlTeam1();
                    $club1->save();

                    if ($club2 === null)
                        $club2 = new Club;
                    $club2->name = $match->getTeam2()->getName();
                    $club2->logo = $match->getIconUrlTeam2();
                    $club2->save();

                }

                $db_match = $match_list->where('ext_id', $match->getId())->first();
                if ($db_match == null)
                    $db_match = new Match();
                $db_match->ext_id = $match->getId();
                $db_match->match_datetime = $match->getDateTime()->format('Y-m-d H:i:s');
                $db_match->matchday = $match->getGroupOrderID();
                $db_match->club_nr1 = $club1->id;
                $db_match->club_nr2 = $club2->id;
                $db_match->erg1 = 0;
                $db_match->erg2 = 0;
                $db_match->save();

            }
            $groups->match_type->touch();
        }
    }
}