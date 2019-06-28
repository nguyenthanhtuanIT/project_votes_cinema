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
    public function update(array $attributes, $id)
    {
        if (!empty($attributes['movie_selected'])) {
            $statistical = Statistical::find($id);
            $vote_id = $statistical->vote_id;
            $check = Statistical::where(['vote_id' => $vote_id, 'movie_selected' => 1])->get();
            if ($check->count() == 1) {
                foreach ($check as $value) {
                    $value->update(['movie_selected' => 0]);
                }
            }

        }
        $result = parent::update($attributes, $id);
        return $result;
    }
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function inforAll()
    {
        $arr = array();
        $vote_id = Statistical::get()->unique('vote_id');
        foreach ($vote_id as $value) {
            $vote = Vote::find($value->vote_id);

            $sta = Statistical::where(['vote_id' => $value->vote_id,
                'movie_selected' => 1])->first();
            if ($sta) {
                $film = Films::find($sta->films_id);
                $ticket_outsite = Register::where('vote_id', $value->vote_id)->sum('ticket_outsite');
                $arr[] = array('name_vote' => $vote->name_vote,
                    'films' => $film->name_film,
                    'amount_vote' => $sta->amount_votes,
                    'amount_register' => $sta->amount_registers,
                    'total_ticket' => $vote->total_ticket,
                    'ticket_outsite' => $ticket_outsite);
            } else {
                return response()->json(['status' => 'film selected not data']);
            }
        }
        return $arr;

    }
    public function inforByVote($vote_id)
    {
        $vote = Vote::find($vote_id);

        $sta = Statistical::where(['vote_id' => $vote_id,
            'movie_selected' => 1])->first();
        if ($sta) {
            $film = Films::find($sta->films_id);
            $ticket_outsite = Register::where('vote_id', $vote_id)->sum('ticket_outsite');
            return response()->json(['name_vote' => $vote->name_vote,
                'films' => $film->name_film,
                'amount_vote' => $sta->amount_votes,
                'amount_register' => $sta->amount_registers,
                'total_ticket' => $vote->total_ticket,
                'ticket_outsite' => $ticket_outsite]);
        } else {
            return response()->json(['status' => 'film selected not data']);
        }

    }
    public function amountVoteOfFilm($vote_id)
    {
        $infor = array();
        $vote = Vote::find($vote_id);
        if ($vote) {
            $data = Statistical::where('vote_id', $vote_id)->get();
            //dd($$v->films_id);
            $film = Films::all();
            foreach ($data as $v) {
                foreach ($film as $val) {
                    if ($v->films_id != null) {
                        if ($v->films_id == $val->id) {
                            $infor[] = array($val->name_film, $v->amount_votes);
                        }
                    } else {
                        return $res = array('status' => 'not data');
                    }
                }
            }
            return $res = array('name_vote' => $vote->name_vote, 'infor' => $infor);
        } else {
            return $res = array('status' => 'not data');
        }
    }
    public function delAll($vote_id)
    {
        $del = Statistical::where('vote_id', $vote_id)->delete();
        return response()->json(null, 204);
    }
}
