<?php

namespace App\Repositories\Eloquent;

use App\Models\VoteDetails;
use App\Presenters\VoteDetailsPresenter;
use App\Repositories\Contracts\VoteDetailsRepository;
use App\Services\VoteService;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

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

    public function create(array $attributes)
    {
        $VoteDetails = parent::create($attributes);
        VoteService::add($VoteDetails['data']['attributes']['film_id']);
        return $VoteDetails;
    }
    public function checkVotes(array $attributes)
    {
        $data = $this->model()::where('user_id', $attributes['user_id'])->where('vote_id', $attributes['vote_id'])->first();
        $check = 'false';
        if ($data) {
            $film_id = $data->film_id;
            $check = 'true';
            $result[] = array('check' => $check,
                'film_id' => $film_id);
        } else {
            $result[] = array('check' => $check);
        }

        return $result;
    }

}
