<?php

namespace App\Repositories\Eloquent;

use App\Models\Random;
use App\Presenters\RandomPresenter;
use App\Repositories\Contracts\RandomRepository;
use Illuminate\Http\Response;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class RandomRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class RandomRepositoryEloquent extends BaseRepository implements RandomRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Random::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return RandomPresenter::class;
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
        $vote_id = 0;
        $check = 0;
        $array = explode(';', $attributes['rand']);
        for ($i = 0; $i < count($array); $i++) {
            $ar = explode(',', $array[$i]);
            for ($j = 0; $j < count($ar); $j++) {
                $vote_id = $ar[0];
            }
        }
        $check = Random::where('vote_id', $vote_id)->count();
        if ($check != 0) {
            return response()->json('vote_id exited', Response::HTTP_BAD_REQUEST);
        } else {
            $arr = explode(';', $attributes['rand']);
            for ($i = 0; $i < count($arr); $i++) {
                $a = explode(',', $arr[$i]);
                $vote_id = $a[0];
                $random = new Random;
                $random->vote_id = $a[0];
                $random->seats = $a[1];
                $random->viewers = $a[2];
                $random->save();
            }

            //$rand = parent::create($attributes);
            $all = Random::where('vote_id', $vote_id)->get();
            return response()->json($all);
        }
    }
    public function chairsByVote($vote_id)
    {
        $result = Random::where('vote_id', $vote_id)->get();
        return response()->json($result);
    }
}
