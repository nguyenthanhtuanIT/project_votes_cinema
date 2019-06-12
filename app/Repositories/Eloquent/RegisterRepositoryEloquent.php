<?php

namespace App\Repositories\Eloquent;

use App\Models\Chair;
use App\Models\Register;
use App\Presenters\RegisterPresenter;
use App\Repositories\Contracts\RegisterRepository;
use App\Services\StatisticalService;
use App\Services\VoteService;
use App\User;
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
        $validate = $this->model()::where([
            'user_id' => $attributes['user_id'],
            'vote_id' => $attributes['vote_id'],
        ])->count();
        if ($validate == 1) {
            return response()->json('ready exited', Response::HTTP_BAD_REQUEST);
        } else {
            $register = parent::create($attributes);
            StatisticalService::addRegister($register['data']['attributes']['film_id'], $register['data']['attributes']['vote_id']);
            VoteService::addTicket($register['data']['attributes']['vote_id'], $register['data']['attributes']['ticket_number']);
            return $register;
        }

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
    }
    public function checkRegister(array $attributes)
    {
        $check = false;
        $guest = false;
        $arr = array();
        $data = Register::where(['user_id' => $attributes['user_id'], 'vote_id' => $attributes['vote_id']])->get();
        $data1 = Register::where('vote_id', $attributes['vote_id'])->where('ticket_number', '>', 1)->get();
        //dd($data1->count());
        if (count($data) != 0) {
            $check = true;
            return response()->json(['check' => $check, 'guest' => $guest, 'user_id' => $attributes['user_id']]);
        }
        if ($data1->count() != 0) {
            foreach ($data1 as $value) {
                $peo = explode(',', $value->best_friend);
                for ($i = 0; $i < count($peo); $i++) {
                    if ($peo[$i] == $attributes['user_id']) {
                        $check = true;
                        $guest = true;
                        $id = $value->user_id;
                        $user = User::find($id);
                        return response()->json(['check' => $check, 'guest' => $guest, 'fullname' => $user->full_name, 'avatar' => $user->avatar, 'user_id' => $id]);
                        break;
                    }
                }
            }
        }

    }
    public function delRegister(array $attributes)
    {
        $data = Register::where([
            'vote_id' => $attributes['vote_id'],
            'user_id' => $attributes['user_id']])->first();
        $del = $this->delete($data->id);
        return $del;
    }
    public function guestRefuse(array $attributes)
    {
        $vote_id = $attributes['vote_id'];
        $user_id = $attributes['user_id'];
        $guest_id = $attributes['guest_id'];
        $data = Register::where(['vote_id' => $vote_id,
            'user_id' => $user_id])->first();
        $arr = explode(',', $data->best_friend);
        for ($i = 0; $i < count($arr); $i++) {
            if ($arr[$i] == $guest_id) {
                unset($arr[$i]);
                break;
            }
        }
        $str = implode(',', $arr);
        $num = count($arr) + 1;
        $up = Register::where(['vote_id' => $vote_id,
            'user_id' => $user_id])->update(['best_friend' => $str, 'ticket_number' => $num]);
        if ($up == 1) {
            $new = Register::where(['vote_id' => $vote_id,
                'user_id' => $user_id])->first();
            VoteService::updateTicket($vote_id, $data->ticket_number, $new->ticket_number);
        }
        return $c = 'success';
    }
    public function shuffle_seats($seats = [[]], $viewers = [[]])
    {
        $seats = array_values($seats);
        $viewers = array_values($viewers);
        // seats or viewers list is empty
        if (empty($seats) || empty($seats[0]) || empty($viewers) || empty($viewers[0])) {
            return [
                'status' => 'success',
                'data' => [],
            ];
        }
        // validate inputs
        $original_seats = $original_viewers = [];
        foreach ($seats as $key => $seats_group) {
            if (!is_array($seats_group)) {
                return [
                    'status' => 'failed',
                    'data' => 'The data is invalid (seats)',
                ];
            } elseif (!empty($seats_group)) {
                $original_seats = array_merge($original_seats, $seats_group);
            } else {
                unset($seats[$key]);
            }
        }
        foreach ($viewers as $key => $viewers_group) {
            if (!is_array($viewers_group)) {
                return [
                    'status' => 'failed',
                    'data' => 'The data is invalid (viewers)',
                ];
            } elseif (!empty($viewers_group)) {
                $original_viewers = array_merge($original_viewers, $viewers_group);
            } else {
                unset($viewers[$key]);
            }
        }
        // number of viewers must smaller than number of seats
        if (count($original_viewers) > count($original_seats)) {
            return [
                'status' => 'failed',
                'data' => 'Not enoght seats',
            ];
        }

        // prepare data: sort viewers and shuffle seats...
        array_multisort(array_map('count', $viewers), SORT_DESC, $viewers);
        shuffle($seats);
        $positions = [];
        $seats_count = [];
        // count the seats of each group
        foreach ($seats as $key => $group) {
            $seats_count[$key] = count($group);
        }

        // set viewers group to seats group randomly
        foreach ($viewers as $viewers_group_key => $viewers_group) {
            $i = 0;
            foreach ($seats as $seats_group_key => $seats_group) {
                if (count($viewers_group) <= $seats_count[$seats_group_key]) {
                    $positions[$seats_group_key][] = $viewers_group;
                    $seats_count[$seats_group_key] = $seats_count[$seats_group_key] - count($viewers_group);
                    unset($viewers[$viewers_group_key]);
                    break;
                } elseif (++$i == count($seats)) {
                    return [
                        'status' => 'failed',
                        'data' => 'The data is invalid',
                    ];
                }
            }
        }

        // set viewer to seat randomly
        $viewer_to_seat = [];
        foreach ($seats as $group_key => $seat_group) {
            if (!empty($positions[$group_key])) {
                shuffle($positions[$group_key]);
                $list = call_user_func_array('array_merge', $positions[$group_key]);
                foreach ($seat_group as $seat_key => $seat) {
                    $viewer_to_seat[$seat] = $list[$seat_key] ?? '';
                }
            }
        }
        // back to original order of seats
        $results = [];
        foreach ($original_seats as $key => $seat) {
            $results[$seat] = $viewer_to_seat[$seat] ?? '';
        }

        return [
            'status' => 'success',
            'data' => $results,
        ];
    }
    public function randChair(array $attributes)
    {
        $data = Register::where('vote_id', $attributes['vote_id'])->get();
        $data1 = Chair::where('vote_id', $attributes['vote_id'])->get();
        $arr = $arr1 = $d = $b = $c = array();
        foreach ($data as $val) {
            if ($val->ticket_number == 1) {
                $b[] = array($val->user_id);
            } elseif ($val->ticket_number > 1) {
                $c[] = array($val->user_id . ',' . $val->best_friend);
            }
            $arr = array_merge($c, $b);
        }
        foreach ($data1 as $val) {
            $arr1[] = array($val->status_chairs);
        }
        //return $arr1;
        return $this->shuffle_seats($arr1, $arr);
    }
}
