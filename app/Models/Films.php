<?php

namespace App\Models;

use App\Models\TypeCinema;
use App\Models\Vote;

/**
 * Class Films.
 *
 * @package namespace App\Models;
 */
class Films extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name_film', 'img', 'projection_date', 'projection_time', 'type_cinema_id', 'cinema_id', 'vote_id',
        'language', 'age_limit', 'detail', 'trailer_url', 'price_film', 'curency', 'vote_number', 'register_number'];

    public function getTypeFilms()
    {
        $type = TypeCinema::where('id', $this->type_cinema_id)
            ->value('name_type_cinema');
        return $type;
    }
    public function getStatusVote()
    {
        $status = Vote::where('id', $this->vote_id)->value('status_vote');
        return $status;
    }
    public function votes()
    {
        return $this->hasOne(\App\Models\Vote::class, 'vote_id');
    }
}
