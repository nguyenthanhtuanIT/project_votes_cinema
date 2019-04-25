<?php

namespace App\Repositories\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Contracts\Vote_detailsRepository;
use App\Presenters\VoteDetailsPresenter;
use App\Models\VoteDetails;

/**
 * Class VoteDetailsRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class VoteDetailsRepositoryEloquent extends BaseRepository implements VoteDetailsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return VoteDetails::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return VoteDetailsPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
