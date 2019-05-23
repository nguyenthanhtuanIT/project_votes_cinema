<?php

namespace App\Models;
use App\Models\Vote;

/**
 * Class Vote.
 *
 * @package namespace App\Models;
 */
class Vote extends BaseModel {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name_vote', 'user_id',
		'status_vote', 'detail', 'time_start_vote', 'time_start_register',
		'time_end'];
}
