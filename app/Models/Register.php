<?php

namespace App\Models;

use App\Models\Films;
use App\Models\Vote;
use App\User;

/**
 * Class Register.
 *
 * @package namespace App\Models;
 */
class Register extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'vote_id',
        'film_id', 'ticket_number', 'best_friend', 'ticket_outsite'];

    public function getNameFilms()
    {
        $name = Films::find($this->film_id);
        return $name->name_film;
    }
    public function getTitleVote()
    {
        $name = Vote::find($this->vote_id);
        return $name->name_vote;
    }
    public function getUser()
    {
        $name = User::where('id', $this->user_id)->select('full_name', 'email')
            ->get();
        return $name;
    }
    public function getFriend()
    {
        $arr = array();
        if (!empty($this->best_friend)) {
            $list = explode(',', $this->best_friend);
            for ($i = 0; $i < count($list); $i++) {
                if (is_numeric($list[$i])) {
                    $user = User::find($list[$i]);
                    $arr[] = $user->full_name;
                } else {
                    $arr[] = $list[$i];
                }

            }

        }
        return $arr;
    }
}
