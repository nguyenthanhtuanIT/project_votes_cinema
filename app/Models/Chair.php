<?php

namespace App\Models;

/**
 * Class Chair.
 *
 * @package namespace App\Models;
 */
class Chair extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['vote_id', 'amount_chairs', 'chairs'];
    protected $hidden = [];
    public function getChairsAttribute($value)
    {
        return explode(',', $value);
    }
}
