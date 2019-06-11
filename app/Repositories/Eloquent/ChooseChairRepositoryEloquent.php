<?php

namespace App\Repositories\Eloquent;

use App\Models\ChooseChair;
use App\Models\Register;
use App\Presenters\ChooseChairPresenter;
use App\Repositories\Contracts\ChooseChairRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ChooseChairRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class ChooseChairRepositoryEloquent extends BaseRepository implements ChooseChairRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ChooseChair::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return ChooseChairPresenter::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    public function ticketUser(array $attributes)
    {
        $ticket = Register::where('user_id', auth()->user()->id)
            ->where('vote_id', $attributes['vote_id'])->pluck('ticket_number');
        return $ticket;
    }
    public function checkChoosed(array $attributes)
    {
        $check = false;
        $count = $this->model()::where(['user_id' => $attributes['user_id'], 'vote_id' => $attributes['vote_id']])->count();
        if ($count == 1) {
            $check = true;
        }
        return response()->json([$check]);
    }
    public function reChoose(array $attributes)
    {
        $find = $this->model()::where(['user_id' => $attributes['user_id'],
            'vote_id' => $attributes['vote_id']])->first();
        $del = $this->model()::find($find->id);
        $del->delete();
        $res = parent::create($attributes);
        return $res;
    }

}
