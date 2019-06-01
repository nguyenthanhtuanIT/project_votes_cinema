<?php

namespace App\Repositories\Eloquent;

use App\Models\Chair;
use App\Presenters\ChairPresenter;
use App\Repositories\Contracts\ChairRepository;
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
        if (isset($attributes['row_of_seats'])) {
            $validate = $this->model()::where([
                'row_of_seats' => $attributes['row_of_seats'],
                'vote_id' => $attributes['vote_id'],
            ])->count();
            if ($validate > 0) {
                return 'attributes aready exited';
            } else {
                $chairs = parent::create($attributes);
                return $chairs;
            }

        }
    }
    public function diagramChairByVote(array $attributes)
    {
        $vote_id = $attributes['vote_id'];
        $diagram = $this->model()::where('vote_id', $vote_id)->get();
        return $diagram;
    }
}
