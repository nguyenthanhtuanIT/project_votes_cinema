<?php

namespace App\Models;

/**
 * Class Room.
 *
 * @package namespace App\Models;
 */
class Room extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['cinema_id', 'name_room', 'total_chairs'];

}
