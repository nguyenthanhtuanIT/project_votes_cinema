<?php

namespace App\Repositories\Eloquent;

use App\Models\Chair;
use App\Models\ChooseChair;
use App\Models\Register;
use App\Models\Vote;
use App\Presenters\ChooseChairPresenter;
use App\Repositories\Contracts\ChooseChairRepository;
use App\User;
use Illuminate\Http\Response;
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
    public function create(array $attributes)
    {
        $validate = $this->model()::where(['user_id' => $attributes['user_id'], 'vote_id' => $attributes['vote_id']])->count();
        if ($validate == 1) {
            $update = $this->model()::where(['user_id' => $attributes['user_id'], 'vote_id' => $attributes['vote_id']])->update(['seats' => $attributes['seats']]);
            return $this->model()::where(['user_id' => $attributes['user_id'], 'vote_id' => $attributes['vote_id']])->first();
        } else {
            $seats = parent::create($attributes);
            return $seats;
        }
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
        $user = '';
        $register = Register::where('vote_id', $attributes['vote_id'])->where('ticket_number', '>', 1)->get();
        foreach ($register as $val) {
            $arr = explode(',', $val->best_friend);
            for ($i = 0; $i < count($arr); $i++) {
                if ($arr[$i] == $attributes['user_id']) {
                    $user = $val->user_id;
                    break;
                }
            }
        }
        if ($user == '') {
            $data = $this->model()::where(['user_id' => $attributes['user_id'], 'vote_id' => $attributes['vote_id']])->first();
            if ($data) {
                if ($data->count() != 0) {
                    $check = true;
                    return array('check' => $check, 'seats' => $data->seats);
                }
            } else {
                $data2 = $this->model()::where(['user_id' => $user, 'vote_id' => $attributes['vote_id']])->first();
                if ($data2) {
                    if ($data2->count() != 0) {
                        $check = true;
                        return array('check' => $check, 'seats' => $data2->seats);
                    }
                }
            }
        }
        return array('check' => $check);
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
    public function randChair(array $attributes)
    {
        $vote = Vote::find($attributes['vote_id']);
        if ($vote->status_vote != 'booking_chair') {
            return response()->json('time is invalid', Response::HTTP_BAD_REQUEST);
        } else {
            $data = Register::where('vote_id', $vote->id)->get();
            $data1 = Chair::where('vote_id', $vote->id)->get();
            if (count($data1) == 0) {
                return response()->json('not data chairs', Response::HTTP_BAD_REQUEST);
            }

            $publish = $seats = $viewers = $b = $c = $a = $r = array();
            foreach ($data as $val) {
                if ($val->ticket_number == 1) {
                    $name = User::find($val->user_id);
                    $a[] = array($name->full_name);
                } elseif ($val->ticket_number > 1) {
                    $n = User::find($val->user_id);
                    $b = array($n->full_name);
                    $ex = explode(',', $val->best_friend);
                    for ($i = 0; $i < count($ex); $i++) {
                        if (is_numeric($ex[$i])) {
                            $k = (int) $ex[$i];
                            if ($k != 0) {
                                $name = User::find($k);
                                $b[] = $name->full_name;
                            }
                        } else {
                            $b[] = $ex[$i];
                        }
                    }
                    $c[] = $b;
                }
            }
            $viewers = array_merge($a, $c);
            //seats
            foreach ($data1 as $val) {
                $arr = $val->chairs;
                $d = array();
                for ($i = 0; $i < count($arr); $i++) {
                    $d[] = $arr[$i];
                }
                sort($d, SORT_STRING);
                for ($i = 0; $i < count($d); $i++) {
                    if ($i == (count($d) - 1)) {
                        $str = substr($d[$i], 0, 1);
                        $num = (int) substr($d[$i], 1);
                        $str1 = substr($d[$i - 1], 0, 1);
                        $num1 = (int) substr($d[$i - 1], 1);
                        if (ord($str) == ord($str1) && $num1 == $num - 1) {
                            $publish[] = $d[$i];
                            $r[] = $publish;
                        } else {
                            $r[] = $publish;
                            $publish = array($d[$i]);
                            $r[] = $publish;
                        }
                    } else {
                        if (empty($publish)) {
                            $publish = array($d[$i]);
                        } else {
                            $str = substr($d[$i], 0, 1);
                            $num = (int) substr($d[$i], 1);
                            $str1 = substr($d[$i - 1], 0, 1);
                            $num1 = (int) substr($d[$i - 1], 1);
                            if (ord($str) == ord($str1) && $num1 == $num - 1) {
                                $publish[] = $d[$i];
                            } else {
                                $r[] = $publish;
                                $publish = array($d[$i]);
                            }
                        }
                    }
                }
                //dd($str);
                $seats = $r;
                $result = $this->shuffle_seats($seats, $viewers, $vote->id);
                return $result;
            }
        }
    }
    public function delAll($vote_id)
    {
        $del = ChooseChair::where('vote_id', $vote_id)->delete();
        return response()->json(null, 204);
    }
    public function shuffle_seats($seats = [], $viewers = [], $vote_id)
    {
        $seats = array_values($seats);
        $viewers = array_values($viewers);
        // seats or viewers list is empty
        if (empty($seats) || empty($viewers)) {
            return [
                'status' => 'success',
                'data' => [],
            ];
        }
        // validate inputs
        $original_seats = $original_viewers = [];
        foreach ($seats as $key => $seats_group) {
            if (!is_array($seats_group)) {
                // return [
                //     'status' => 'failed',
                //     'data' => 'The data is invalid (seats)',
                // ];
                return response()->json('The data is invalid (seats)', Response::HTTP_BAD_REQUEST);
            } elseif (!empty($seats_group)) {
                $original_seats = array_merge($original_seats, $seats_group);
            } else {
                unset($seats[$key]);
            }
        }
        foreach ($viewers as $key => $viewers_group) {
            if (!is_array($viewers_group)) {
                // return [
                //     'status' => 'failed',
                //     'data' => 'The data is invalid (viewers)',
                // ];
                return response()->json('The data is invalid (viewers)', Response::HTTP_BAD_REQUEST);
            } elseif (!empty($viewers_group)) {
                $original_viewers = array_merge($original_viewers, $viewers_group);
            } else {
                unset($viewers[$key]);
            }
        }
        // number of viewers must smaller than number of seats
        if (count($original_viewers) > count($original_seats)) {
            // return [
            //     'status' => 'failed',
            //     'data' => 'Not enoght seats',
            // ];

            return response()->json('row_of_seats exited', Response::HTTP_BAD_REQUEST);
        }

        // prepare data: sort viewers and shuffle seats...
        shuffle($viewers);
        usort($viewers, function ($a, $b) {
            if (count($a) < count($b)) {return 1;}
            if (count($a) > count($b)) {return -1;}
            return 0;
        });
        shuffle($seats);
        // count the items of each group
        $seats_count = [];
        foreach ($seats as $key => $group) {
            $seats_count[$key] = count($group);
        }
        // set positions to viewers
        $positions = $this->array_2_slots($viewers, $seats_count);

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
            'vote_id' => $vote_id,
            'status' => 'success',
            'data' => $results,
        ];
    }

    /**
     * Set array to slots
     * @param: $array1, $slots, $positions
     * @return: list with format 'key' (from $array2) => 'value' (from $array1)
     * @author: AuTN
     */
    private function array_2_slots($array1 = [], &$slots = [], &$positions = [])
    {
        foreach ($array1 as $array1_group_key => $array1_group) {
            $i = 0;
            $max_available_slots_of_array2 = [0];
            foreach ($slots as $slots_group_key => $slots_group_value) {
                if ($slots_group_value > array_values($max_available_slots_of_array2)[0]) {
                    $max_available_slots_of_array2 = [
                        $slots_group_key => $slots_group_value,
                    ];
                }
                if (count($array1_group) <= $slots_group_value) {
                    // set to list
                    $positions[$slots_group_key][] = $array1_group;
                    $slots[$slots_group_key] = $slots_group_value - count($array1_group);
                    break;
                } elseif (++$i == count($slots)) {
                    // if not enoght slots, break to 2 lists
                    reset($max_available_slots_of_array2);
                    $max_slots_key = key($max_available_slots_of_array2);
                    $part1 = array_slice($array1_group, 0, $slots[$max_slots_key]);
                    $part2 = array_slice($array1_group, $slots[$max_slots_key]);
                    $positions[$max_slots_key][] = $part1;
                    $slots[$max_slots_key] = 0;
                    $this->array_2_slots([$part2], $slots, $positions);
                }
            }
        }

        return $positions;
    }
}
