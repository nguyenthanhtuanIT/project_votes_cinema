<?php

namespace App\Models;

use App\Models\Vote;
use App\User;

/**
 * Class ChooseChair.
 *
 * @package namespace App\Models;
 */
class ChooseChair extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'vote_id', 'seats'];

    public function getUser()
    {
        $user = User::find($this->user_id)->value('full_name');
        return $user;
    }
    public function getVote()
    {
        $vote = Vote::find($this->vote_id)->value('name_vote');
        return $vote;
    }

}
