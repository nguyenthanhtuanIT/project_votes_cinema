<?php

namespace App\Models;

use App\Models\Films;
use App\Models\Vote;
use App\User;

/**
 * Class VoteDetails.
 *
 * @package namespace App\Models;
 */
class VoteDetails extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'film_id', 'vote_id'];

    public function getFilm()
    {

        $film = Films::find($this->film_id);
        return $film->name_film;
    }
    public function getUser()
    {

        $user = User::find($this->user_id);
        return $user->full_name;
    }
    public function getVote()
    {
        $vote = Vote::find($this->vote_id);
        return $vote->name_vote;
    }
}
