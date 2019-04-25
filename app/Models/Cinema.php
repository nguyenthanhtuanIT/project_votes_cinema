<?php

namespace App\Models;

/**
 * Class Cinema.
 *
 * @package namespace App\Models;
 */
class Cinema extends BaseModel {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $table = "cinemas";
	protected $fillable = [
		'name_cinema',
		'adress',

	];

	public function film() {
		return $this->hasMany(\App\Models\Films::class, 'id_cinema');
	}

}
