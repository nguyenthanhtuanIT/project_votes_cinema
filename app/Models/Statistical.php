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
    protected $fillable = ['vote_id', 'films_id', 'amount_votes', 'movie selected'];

}
