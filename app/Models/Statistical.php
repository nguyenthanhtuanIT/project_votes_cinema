<?php

namespace App\Models;

/**
 * Class Statistical.
 *
 * @package namespace App\Models;
 */
class Statistical extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $fillable = ['vote_id', 'films_id', 'amount_votes', 'movie_selected'];
    public function getVote()
    {
        $name = Vote::where('id', $this->vote_id)->value('name_vote');
        return $name;
    }
    public function getNameFilms()
    {
        $name = Films::where('id', $this->films_id)->value('name_film');
        return $name;
    }
}
