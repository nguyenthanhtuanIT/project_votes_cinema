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
	protected $fillable = ['name_vote', 'id_user',
		'status_vote', 'detail', 'dead_line'];

}
