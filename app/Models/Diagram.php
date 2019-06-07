<?php

namespace App\Models;

/**
 * Class Diagram.
 *
 * @package namespace App\Models;
 */
class Diagram extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;

    protected $fillable = ['room_id', 'row_of_seats', 'amount_chairs_of_row', 'chairs'];

}
