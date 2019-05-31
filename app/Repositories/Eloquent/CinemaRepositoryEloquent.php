<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\CinemaRepository;
use App\Presenters\CinemaPresenter;
use App\Models\Cinema;

/**
 * Class CinemaRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class CinemaRepositoryEloquent extends BaseRepository implements CinemaRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Cinema::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return CinemaPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
