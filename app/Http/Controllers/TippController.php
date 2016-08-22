<?php

namespace App\Http\Controllers;

use App\Group;
use App\Match;
use App\MatchTip;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Pagination\Paginator;


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
        /* Set current page of Pagination */
        $currentPage = setActivePage($request->page);

        /* Fetch and update League data if available */
        $openliga = new \App\Library\DBOpenLigaConnector();
        $openliga->updateOpenLigaDataByGroup($id);

        /* Calculate Ranking for all user */
        $user_list = calcAndSavePoints($id)->load('user');

        /* Fetch Matchdata for this group and day */
        $match_list = Match::with('club1', 'club2')->whereGroup($id)
            ->paginate(Match::where('matchday',$currentPage)->whereGroup($id)->count());

        /* Fetch User bets for these games */
        $tipp_list = MatchTip::with('match')->whereMatchday($currentPage)->where('group_id', $id)
            ->orderBy('user_id')->orderBy('id')->get();

        return view('tippspiel.results', compact('match_list', 'user_list', 'tipp_list'));
    }

    /**
     * Change your own result bets.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id, Request $request)
    {
        $currentPage = setActivePage($request->page);

        $openliga = new \App\Library\DBOpenLigaConnector();
        $openliga->updateOpenLigaDataByGroup($id);

        $mt_list = MatchTip::where('group_id', $id)->authUser()->with('match.club1', 'match.club2')
            ->paginate(Match::where('matchday', $currentPage)->whereGroup($id)->count());
        $group = Group::find($id);

        return view('tippspiel.edit', compact('mt_list', 'group'));
    }


    /**
     * Update your bets
     *
     * @param $id
     * @param Requests\TippRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Requests\TippRequest $request){
        $lastKey = 1; $info = false;
        $matches_tips = MatchTip::with('match')->get();

        if($request->club1_tipp){
            foreach($request->club1_tipp as $i => $tipp){
                ($tipp == '')?$t1 = null: $t1 = $tipp;
                ($request->club2_tipp[$i] == '')?$t2 = null: $t2 = $request->club2_tipp[$i];
                $matchtip = $matches_tips->find($i);

                // Update match if it didn't start yet
                if(Carbon::now()->subMinutes(30) <= $matchtip->match->match_datetime)
                    $matchtip->update(['t1' => $t1, 't2' => $t2]);
                $lastKey = $i;

                // Check for values beyond limit to inform user about possible mistake.
                if($t1 >= 10 || $t2 >= 10)
                    $info = true;
            }
        }

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
        $openliga = new \App\Library\DBOpenLigaConnector();
        $openliga->updateOpenLigaDataByGroup($id);

        $user_groups = calcAndSavePoints($id);


        return view('tippspiel.ranking', compact('user_groups'));

    }
}
