<?php

namespace App\Models;

use App\Models\TypeCinema;

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
		'language', 'age_limit', 'detail', 'trailer_url', 'price_film', 'curency', 'vote_number', 'register_number'];

	public function getTypeFilms() {
		$type = TypeCinema::where('id', $this->id_type_cinema)->value('name_type_cinema');
		return $type;
	}
}