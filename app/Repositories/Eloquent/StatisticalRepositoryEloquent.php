<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\StatisticalRepository;
use App\Presenters\StatisticalPresenter;
use App\Models\Statistical;

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
    
}
