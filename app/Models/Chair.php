<?php

namespace App\Models;

/**
 * Class Chair.
 *
 * @package namespace App\Models;
 */
class Chair extends BaseModel {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['code_chairs', 'vote_id', 'row_of_seats', 'number_start', 'number_end'];

}
