<?php

namespace App\Repositories\Eloquent;

use App\Models\Diagram;
use App\Presenters\DiagramPresenter;
use App\Repositories\Contracts\DiagramRepository;
use Illuminate\Http\Response;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

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
    public function create(array $attributes)
    {
        //$diagram = '';
        $validate = $this->model()::where([
            'row_of_seats' => $attributes['row_of_seats'],
            'room_id' => $attributes['room_id'],
        ])->count();
        if ($validate == 1) {
            return response()->json('row_of_seats exited', Response::HTTP_BAD_REQUEST);
        } else {
            $diagram = parent::create($attributes);
            return $diagram;
        }

    }
}
