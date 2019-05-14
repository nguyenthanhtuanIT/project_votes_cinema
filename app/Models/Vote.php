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
		'status_vote', 'detail', 'time_start',
		'time_end'];
	// protected $events = ['created' => Events\NewVote::class];
}
