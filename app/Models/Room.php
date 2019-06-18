<?php

namespace App\Models;

use App\Models\Cinema;

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

    public function getCinema()
    {
        $name = Cinema::find($this->cinema_id);
        return $name->cinema_name;
    }
}
