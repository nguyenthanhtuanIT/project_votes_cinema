<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\DiagramRepository;
use App\Presenters\DiagramPresenter;
use App\Models\Diagram;

/**
 * Class DiagramRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class DiagramRepositoryEloquent extends BaseRepository implements DiagramRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Diagram::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return DiagramPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
