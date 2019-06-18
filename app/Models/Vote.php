<?php

namespace App\Models;

use App\Models\Cinema;
use App\Models\Room;
use App\Models\Vote;
use App\User;

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
    // public $films = $this->list_films;
    protected $fillable = ['name_vote', 'list_films', 'user_id', 'room_id',
        'background', 'status_vote', 'detail', 'time_voting', 'time_registing', 'time_booking_chair', 'time_end', 'total_ticket'];
    public function getFilms()
    {
        $str = implode(',', $this->list_films);
        $list = explode(',', $str);
        $arr = array();
        for ($i = 0; $i < count($list); $i++) {
            $film = Films::select('id', 'name_film')->find($list[$i]);
            $arr[] = $film;
        }
        return $arr;
    }

    public function getListFilmsAttribute($value)
    {
        return explode(',', $value);
    }
    public function inforRooms()
    {
        $room = Room::find($this->room_id);

        if ($room) {
            $cinema = Cinema::find($room->cinema_id);
            return $arr = array('name_room' => $room->name_room, 'cinema' => $cinema->name_cinema);
        }

    }
    public function getUser()
    {
        $use = User::find($this->user_id);
        return $use->full_name;
    }
}
