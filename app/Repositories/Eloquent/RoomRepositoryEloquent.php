<?php

namespace App\Repositories\Eloquent;

use App\Models\Room;
use App\Presenters\RoomPresenter;
use App\Repositories\Contracts\RoomRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class RoomRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class RoomRepositoryEloquent extends BaseRepository implements RoomRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Room::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return RoomPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
