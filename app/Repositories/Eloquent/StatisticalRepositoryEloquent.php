<?php

namespace App\Repositories\Eloquent;

use App\Models\Films;
use App\Models\Register;
use App\Models\Statistical;
use App\Models\Vote;
use App\Presenters\StatisticalPresenter;
use App\Repositories\Contracts\StatisticalRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class StatisticalRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class StatisticalRepositoryEloquent extends BaseRepository implements StatisticalRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Statistical::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return StatisticalPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function inforByVote($vote_id)
    {
        $vote = Vote::find($vote_id);
        if ($vote) {
            $sta = Statistical::where(['vote_id' => $vote_id,
                'movie_selected' => 1])->first();
            $film = Films::find($sta->films_id);
            $ticket_outsite = Register::where('vote_id', $vote_id)->sum('ticket_outsite');
            return response()->json(['name_vote' => $vote->name_vote,
                'films' => $film->name_film,
                'amount_vote' => $sta->amount_votes,
                'amount_register' => $sta->amount_registers,
                'total_ticket' => $vote->total_ticket,
                'ticket_outsite' => $ticket_outsite]);
        } else {
            return response()->json([]);
        }
    }
    public function amountVoteOfFilm($vote_id)
    {
        $infor = array();

        $vote = Vote::find($vote_id);
        if ($vote) {
            $data = Statistical::where('vote_id', $vote_id)->get();
            //dd($vote);
            $film = Films::all();
            foreach ($data as $v) {
                foreach ($film as $val) {
                    if ($v->films_id == $val->id) {
                        $infor[] = array($val->name_film, $v->amount_votes);
                    }
                }

                //$arr = array_merge($name, $num);
            }
            return $res = array('name_vote' => $vote->name_vote, 'infor' => $infor);
        } else {
            return $res = array('status' => 'not data');
        }
    }
}
