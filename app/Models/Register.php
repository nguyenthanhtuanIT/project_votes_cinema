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
    protected $fillable = ['name_register', 'user_id', 'vote_id',
        'film_id', 'ticket_number'];

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
}
