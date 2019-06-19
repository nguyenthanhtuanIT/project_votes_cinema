<?php

namespace App\Models;

use App\Models\Vote;

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
    public function getVote()
    {
        $vote = Vote::find($this->vote_id);
        return $vote->name_vote;
    }
}
