<?php

namespace App\Models;

/**
 * Class Films.
 *
 * @package namespace App\Models;
 */
class Films extends BaseModel {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name_film', 'img', 'projection_date', 'projection_time', 'id_type_cinema', 'id_cinema', 'id_vote',
		'laguage', 'age_limit', 'detail', 'price_film', 'vote_number', 'register_number'];
}