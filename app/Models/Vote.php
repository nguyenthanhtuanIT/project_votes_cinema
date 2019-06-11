<?php

namespace App\Models;

use App\Models\Films;
use App\Models\Vote;

/**
 * Class Vote.
 *
 * @package namespace App\Models;
 */
class Vote extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name_vote', 'list_films', 'user_id', 'room_id',
        'background', 'status_vote', 'detail', 'time_voting', 'time_registing', 'time_booking_chair', 'time_end', 'total_ticket'];
    public function getListFilms()
    {
        $list = explode(',', $this->list_films);
        $arr = array();
        for ($i = 0; $i < count($list); $i++) {
            $film = Films::find($list[$i]);
            $arr[] = $film;
        }
        return $arr;
    }
}
