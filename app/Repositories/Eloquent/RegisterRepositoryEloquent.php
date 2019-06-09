<?php

namespace App\Repositories\Eloquent;

use App\Models\Register;
use App\Presenters\RegisterPresenter;
use App\Repositories\Contracts\RegisterRepository;
use App\Services\StatisticalService;
use App\Services\VoteService;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class RegisterRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class RegisterRepositoryEloquent extends BaseRepository implements RegisterRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Register::class;
    }

    /**
     * Specify Presenter class name
     *
     * @return string
     */
    public function presenter()
    {
        return RegisterPresenter::class;
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
        $register = parent::create($attributes);
        StatisticalService::addRegister($register['data']['attributes']['film_id'], $register['data']['attributes']['vote_id']);
        VoteService::addTicket($register['data']['attributes']['vote_id'], $register['data']['attributes']['ticket_number']);
        return $register;
    }
    public function delete($id)
    {
        $find = Register::find($id);
        StatisticalService::updateRegister($find->film_id, $find->vote_id);
        VoteService::deleteTicket($find->vote_id, $find->ticket_number);
        $register = parent::delete($id);
        return response()->json(null, 204);
    }
    public function update(array $attributes, $id)
    {

        if (!empty($attributes['ticket_number'])) {
            $find = Register::find($id);
            $number_old = $find->ticket_number;
            $register = parent::update($attributes, $id);
            $number_new = $register->ticket_number;
            VoteService::updateTicket($find->vote_id, $number_old, $number_new);
            return $register;
        } else {
            $register = parent::update($attributes, $id);
            return $register;
        }

        // StatisticalService::addRegister($register['data']['attributes']['film_id'], $register['data']['attributes']['vote_id']);
        // VoteService::addTicket($register['data']['attributes']['vote_id'], $register['data']['attributes']['ticket_number']);
        // return $register;
    }
    // public function checkRegister(array $attributes)
    // {
    //     $data = $this->model()::where('user_id', $attributes['user_id'])->where('vote_id', $attributes['vote_id'])->first();
    //     $check = 'false';
    //     if ($data) {
    //         $ticket_number = $data->ticket_number;
    //         $check = 'true';
    //         $result[] = array('check' => $check,
    //             'ticket_number' => $ticket_number);
    //     } else {
    //         $result[] = array('check' => $check);
    //     }
    //     return $result;
    // }
}
