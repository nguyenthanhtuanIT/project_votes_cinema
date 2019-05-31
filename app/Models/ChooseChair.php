<?php

namespace App\Models;

/**
 * Class ChooseChair.
 *
 * @package namespace App\Models;
 */
class ChooseChair extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'vote_id', 'chair_id', 'seats'];

}
