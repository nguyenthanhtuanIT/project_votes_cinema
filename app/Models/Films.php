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
	protected $table = "films";
	protected $fillable = [
		'name_film',
		'projection_date',
		'projection_time',
		'id_type_cinema',
		'id_cinema',
		'id_vote',
		'language',
		'age',
		'detail',
		'price_film',
		'vote_number',
		'register_number',

	];
	public function register() {
		return $this->hasMany(\App\Models\Register::class, 'user_films');
	}
	public function cinema() {
		return $this->belongsTo(\App\Models\Cinema::class, 'id_cinema');
	}
	public function vote() {
		return $this->belongsTo(\App\Models\Vote::class, 'id_vote');
	}
	public function type_cinema() {
		return $this->belongsTo(\App\Models\TypeCinnema::class, 'id_type_cinema');
	}

}
