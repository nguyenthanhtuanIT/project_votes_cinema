<?php

namespace App\Repositories\Eloquent;

use App\Models\VoteDetails;
use App\Presenters\VoteDetailsPresenter;
use App\Repositories\Contracts\VoteDetailsRepository;
use App\Services\StatisticalService;
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
        StatisticalService::addRow($VoteDetails['data']['attributes']['film_id'], $VoteDetails['data']['attributes']['vote_id']);
        return $VoteDetails;
    }
    public function delete($id)
    {
        $data = VoteDetails::find($id);
        StatisticalService::updateRow($data->film_id, $data->vote_id);
        $VoteDetails = parent::delete($id);
        return response()->json(null, 204);
    }

    public function checkVotes(array $attributes)
    {
        $user_id = $attributes['user_id'];
        $vote_id = $attributes['vote_id'];
        $data = $this->model()::where(['user_id' => $user_id, 'vote_id' => $vote_id])->get();
        if (count($data) != 0) {
            foreach ($data as $value) {
                $arr[] = $value->film_id;
            }
            return response()->json($arr);
        } else {
            return response()->json([]);
        }

    }
}
