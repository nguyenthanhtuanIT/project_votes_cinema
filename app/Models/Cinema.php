<?php

namespace App\Models;

/**
 * Class Cinema.
 *
 * @package namespace App\Models;
 */
class Cinema extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name_cinema', 'address', 'amount_rooms'];

}
