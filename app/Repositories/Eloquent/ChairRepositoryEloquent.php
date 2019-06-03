<?php

namespace App\Repositories\Eloquent;

use App\Models\Chair;
use App\Presenters\ChairPresenter;
use App\Repositories\Contracts\ChairRepository;
use Illuminate\Http\Response;
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
    public function test(array $attributes)
    {
        $attr = $attributes['update_status_chair'];
        $vote_id = $attributes['vote_id'];
        $arr = explode(';', $attr);
        $check = true;
        //dd(count($arr));
        for ($i = 0; $i < count($arr); $i++) {
            $chill_arr = explode(',', $arr[$i]);
            $chair = $this->model()::find($chill_arr[0]);
            $status_chairs = explode(',', $chair->status_chairs);
            if ($chair) {
                for ($k = 0; $k < count($status_chairs); $k++) {
                    if ($status_chairs[$k] == $chill_arr[$k + 1]) {
                        $check = true;
                    } else {
                        if ($status_chairs[$k] == 'empty' && is_numeric($chill_arr[$k + 1])) {
                            $check = true;
                        } else {
                            $check = false;
                            break;
                        }
                    }
                }
            }
            if (!$check) {
                break;
            }
        }
        if ($check) {
            for ($i = 0; $i < count($arr); $i++) {
                $chill_arr = explode(',', $arr[$i]);
                $chair = $this->model()::find($chill_arr[0]);
                $status_chairs = explode(',', $chair->status_chairs);
                if ($chair) {
                    for ($k = 0; $k < count($status_chairs); $k++) {
                        $status_chairs[$k] = $chill_arr[$k + 1];
                    }
                    $string = implode(',', $status_chairs);
                    $chair_update = $chair->update(['status_chairs' => $string]);
                }

            }
            return response('ok', 200);
        } else {
            return response('error', 401);
        }

    }
}
