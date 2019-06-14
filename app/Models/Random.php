<?php

namespace App\Models;

use App\User;

/**
 * Class Random.
 *
 * @package namespace App\Models;
 */
class Random extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['vote_id', 'viewers', 'seats'];
    public function nameUser()
    {
        $user = User::find($this->viewers);
        if ($user) {
            return $user->full_name;
        }
    }
}
