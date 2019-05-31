<?php

namespace App\Repositories\Eloquent;

use App\Models\Register;
use App\Presenters\RegisterPresenter;
use App\Repositories\Contracts\RegisterRepository;
use App\Services\RegisterService;
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
    public function create($attributes)
    {
        //$attributes['ticket_number'] = 0;
        $register = parent::create($attributes);
        //var_dump($register);
        RegisterService::add($register['data']['attributes']['film_id'],
            $register['data']['attributes']['ticket_number']);
        return $register;
    }
    public function checkRegister(array $attributes)
    {
        $data = $this->model()::where('user_id', $attributes['user_id'])->where('vote_id', $attributes['vote_id'])->first();
        $check = 'false';
        if ($data) {
            $ticket_number = $data->ticket_number;
            $check = 'true';
            $result[] = array('check' => $check,
                'ticket_number' => $ticket_number);
        } else {
            $result[] = array('check' => $check);
        }
        return $result;
    }
}
