<?php

namespace App\Repositories\Eloquent;

use App\Models\Chair;
use App\Models\ChooseChair;
use App\Models\Vote;
use App\Presenters\ChairPresenter;
use App\Repositories\Contracts\ChairRepository;
use Illuminate\Http\Response;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ChairRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ChairRepositoryEloquent extends BaseRepository implements ChairRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Chair::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return ChairPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function create(array $attributes)
    {
        $validate = $this->model()::where('vote_id', $attributes['vote_id'])->count();
        if ($validate == 1) {
            return response()->json('attributes aready exited', Response::HTTP_BAD_REQUEST);

        } else {
            $vote = Vote::find($attributes['vote_id']);
            if ($vote->status_vote != 'booking_chair') {
                return response()->json('status votes not combined',
                    Response::HTTP_BAD_REQUEST);
            }
        }
        $chairs = parent::create($attributes);
        return $chairs;

    }
    public function diagramChairByVote($vote_id)
    {
        $diagram = $this->model()::where('vote_id', $vote_id)->get();
        return $diagram;
    }
    public function updateChairs(array $attributes)
    {
        $vote_id = $attributes['vote_id'];
        $result = $c_c = $c = array();
        $ch_chair = ChooseChair::where('vote_id', $vote_id)->get();
        $chair = Chair::where('vote_id', $vote_id)->get();
        foreach ($chair as $val) {
            $arr = $val->chairs;
            for ($i = 0; $i < count($arr); $i++) {
                $c[] = $arr[$i];
            }
        }
        foreach ($ch_chair as $val) {
            $arr = explode(',', $val->seats);
            for ($i = 0; $i < count($arr); $i++) {
                $c_c[] = $arr[$i];
            }
        }
        $res = array_diff($c, $c_c);
        foreach ($res as $key => $value) {
            $result[] = $value;
        }
        return response()->json($result);
    }
    public function delAll($vote_id)
    {
        $del = Chair::where('vote_id', $vote_id)->delete();
        return response()->json(null, 204);
    }
}
