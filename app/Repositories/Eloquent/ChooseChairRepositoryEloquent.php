<?php

namespace App\Repositories\Eloquent;

use App\Models\Chair;
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
        $ticket = Register::where('user_id', 1)
            ->where('vote_id', $attributes['vote_id'])->get(['ticket_number']);
        return response()->json($ticket[0]);
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
        $seats = $viewers = $b = $c = $a = array();
        foreach ($data as $val) {
            if ($val->ticket_number == 1) {
                $a[] = array($val->user_id);
            } elseif ($val->ticket_number > 1) {
                $b = array($val->user_id);
                $ex = explode(',', $val->best_friend);
                for ($i = 0; $i < count($ex); $i++) {
                    $k = (int) $ex[$i];
                    $b[] = $k;
                }
                $c[] = $b;
            }
        }
        $viewers = array_merge($a, $c);
        foreach ($data1 as $val) {
            $arr = explode(',', $val->status_chairs);
            $d = array();
            for ($i = 0; $i < count($arr); $i++) {
                $d[] = $arr[$i];
            }
            $seats[] = $d;
        }
        return $this->shuffle_seats($seats, $viewers);
    }

}
