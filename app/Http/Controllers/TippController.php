<?php

namespace App\Http\Controllers;

use App\Group;
use App\League;
use App\Match;
use App\MatchTip;

use Carbon\Carbon;
use Grambas\FootballData\Facades\FootballDataFacade;
use Illuminate\Http\Request;

use App\Http\Requests;


class TippController extends Controller
{
    /**
     * Create a new controller instance.
     * Only for activated user joined this group.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('registered');
        $this->middleware('groupUser');
    }

    /**
     * Show the results and bets of other players.
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id, Request $request)
    {
        $league_id =League::findGroup($id)->id;
        /* Set current page of Pagination */
        $currentPage = setActivePage($request->page, $id);

        //updateMatches($id);

        /* Calculate Ranking for all user */
        $user_list = calcAndSavePoints($id)->load('user');

        /* Fetch Matchdata for this group and day */
        $match_list = Match::with('home_team', 'vis_team')->where('league_id', $league_id)->orderBy('matches.id')->orderBy('date')->orderBy('matchday')
            ->paginate(Match::where([['league_id',$league_id],['matchday', $currentPage]])->count());

        /* Fetch User bets for these games */
        $tipp_list = MatchTip::with('match')->whereMatchday($currentPage)->whereGroup($id)
            ->join('matches', 'match_id','=', 'matches.id')->orderBy('matches.id')->orderBy('matches.date')->orderBy('matches.matchday')
            ->orderBy('group_user_id')->get();

        return view('tippspiel.results', compact('match_list', 'user_list', 'tipp_list'));
    }

    /**
     * View for editing bets
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request)
    {
        $league_id =League::findGroup($id)->id;

        /* Fetch active page for current match if page is empty */
        $currentPage = setActivePage($request->page, $id);

        /* Get football data from API and update DB */
        //updateMatches($id);

        /* Get user bets for matches */
        $mt_list = MatchTip::with('match')->whereGroup($id)->authUser()->with('match.home_team', 'match.vis_team')
            ->join('matches', 'match_id','=', 'matches.id')->orderBy('matches.date')->orderBy('matches.matchday')
            ->paginate(Match::where([['league_id',$league_id],['matchday', $currentPage]])->count());
        $group = Group::find($id);

        return view('tippspiel.edit', compact('mt_list', 'group'));
    }


    /**
     * Update user bets
     *
     * @param $id
     * @param Requests\TippRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Requests\TippRequest $request){
        $lastKey = 1; $info = false;
        $matches_tips = MatchTip::with('match')->whereGroup($id)->authUser()->get();

        /* Update user bets */
        if($request->club1_tipp){
            foreach($request->club1_tipp as $i => $tipp){
                ($tipp == '')?$t1 = null: $t1 = $tipp;
                ($request->club2_tipp[$i] == '')?$t2 = null: $t2 = $request->club2_tipp[$i];
                $matchtip = $matches_tips->find($i);

                // Update match if it didn't start yet
                if(Carbon::now()->addMinutes(30) <= $matchtip->match->date){
                    $matchtip->update(['home_team_bet' => $t1, 'vis_team_bet' => $t2]);
                }
                $lastKey = $i;

                // Check for values beyond limit to inform user about possible mistake.
                if($t1 >= 10 || $t2 >= 10)
                    $info = true;
            }
        }

        /* Flash Info for high values */
        ($info == true)? flash('Falschen Wert eingetragen? Bitte überprüfen.', 'alert-warning') : flash('Erfolgreich eingetragen');

        $matchDay = $matches_tips->find($lastKey)->match->matchday;

        return redirect('/group/'.$id.'/results?page='.$matchDay);
    }

    /**
     * Ranking for all players of this group.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function rank($id){
        //updateMatches($id);
        $user_groups = calcAndSavePoints($id);

        return view('tippspiel.ranking', compact('user_groups'));

    }
}
