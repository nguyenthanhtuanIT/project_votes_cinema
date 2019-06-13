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
        'film_id', 'ticket_number', 'best_friend'];

    public function getNameFilms()
    {
        $name = Films::where('id', $this->film_id)->value('name_film');
        return $name;
    }
    public function getTitleVote()
    {
        $name = Vote::where('id', $this->vote_id)->value('name_vote');
        return $name;
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
                $user = User::find($list[$i]);
                $arr[] = $user->full_name;
            }

        }
        return $arr;
    }
}
