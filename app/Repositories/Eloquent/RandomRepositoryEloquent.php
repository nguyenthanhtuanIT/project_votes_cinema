<?php

namespace App\Repositories\Eloquent;

use App\Models\Random;
use App\Presenters\RandomPresenter;
use App\Repositories\Contracts\RandomRepository;
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
        $check = Random::where('vote_id', $attributes['vote_id'])->count();
        if ($check == 1) {
            return response()->json('vote_id exited', Response::HTTP_BAD_REQUEST);
        } else {
            $rand = parent::create($attributes);
            return $rand;
        }
    }
}
