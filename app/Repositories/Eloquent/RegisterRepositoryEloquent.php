<?php

namespace App\Repositories\Eloquent;

use App\Mail\MailCancel;
use App\Mail\MailFeedback;
use App\Mail\MailInvite;
use App\Models\Register;
use App\Presenters\RegisterPresenter;
use App\Repositories\Contracts\RegisterRepository;
use App\Services\StatisticalService;
use App\Services\VoteService;
use App\User;
use Illuminate\Http\Response;
use Mail;
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
        $ticket_outsite = 0;
        $validate = $this->model()::where([
            'user_id' => $attributes['user_id'],
            'vote_id' => $attributes['vote_id'],
        ])->count();
        $user = User::find($attributes['user_id']);
        $ticket_number = $attributes['ticket_number'];
        if ($validate == 1) {
            return response()->json('ready exited', Response::HTTP_BAD_REQUEST);
        } else {
            if (!empty($attributes['best_friend'])) {
                $arr = explode(',', $attributes['best_friend']);
                if ($ticket_number > count($arr)) {
                    $ticket_outsite = $ticket_number - 1 - count($arr);
                }
                for ($i = 1; $i <= $ticket_outsite; $i++) {
                    $arr[] = "$user->full_name $i";
                }
                for ($i = 0; $i < count($arr); $i++) {
                    if (empty($arr[$i])) {
                        unset($arr[$i]);
                    }
                }
                for ($i = 0; $i < count($arr); $i++) {
                    $us = User::find($arr[$i]);
                    Mail::to($us->email)->queue(new MailInvite($us));
                }
                $attributes['best_friend'] = implode(',', $arr);

            } else {
                $a = explode(',', $attributes['best_friend']);
                $ticket_outsite = $ticket_number - 1;
                for ($i = 1; $i <= $ticket_outsite; $i++) {
                    $a[] = "$user->full_name $i";
                }
                for ($i = 0; $i < count($a); $i++) {
                    if (empty($a[$i])) {
                        unset($a[$i]);
                    }
                }
                $attributes['best_friend'] = implode(',', $a);
            }
            $attributes['ticket_outsite'] = $ticket_outsite;
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
        $data = Register::where(['user_id' => $attributes['user_id'], 'vote_id' => $attributes['vote_id']])->get();
        $data1 = Register::where('vote_id', $attributes['vote_id'])->where('ticket_number', '>', 1)->get();
        //dd($data1->count());
        if (count($data) != 0) {
            foreach ($data as $value) {
                $check = true;
                return response()->json(['check' => $check, 'guest' => $guest, 'user_id' => $value->user_id, 'ticket_number' => $value->ticket_number]);
            }
        } elseif ($data1->count() != 0) {
            foreach ($data1 as $value) {
                $peo = explode(',', $value->best_friend);
                for ($i = 0; $i < count($peo); $i++) {
                    if ($peo[$i] == $attributes['user_id']) {
                        $check = true;
                        $guest = true;
                        $id = $value->user_id;
                        $user = User::find($id);
                        //
                        return response()->json(['check' => $check, 'guest' => $guest, 'fullname' => $user->full_name, 'avatar' => $user->avatar, 'user_id' => $id]);
                        break;
                    }
                }
            }
        }
        return response()->json(['check' => $check, 'guest' => $guest]);
    }
    public function delRegister(array $attributes)
    {
        $data = Register::where([
            'vote_id' => $attributes['vote_id'],
            'user_id' => $attributes['user_id']])->first();
        $user = User::find($attributes['user_id']);

        if (!empty($data->best_friend)) {
            $arr = explode(',', $data->best_friend);
            for ($i = 0; $i < count($arr); $i++) {
                if (is_numeric($arr[$i])) {
                    $guest = User::find($arr[$i]);
                    Mail::to($guest->email)->queue(new MailCancel($user));
                }
            }
        }

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
        $us = User::find($user_id);
        Mail::to($us->email)->queue(new MailFeedback());
        return $c = 'success';

    }

}
