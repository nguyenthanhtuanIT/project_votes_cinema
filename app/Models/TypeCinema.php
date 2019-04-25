<?php

namespace App\Models;

/**
 * Class TypeCinema.
 *
 * @package namespace App\Models;
 */
class TypeCinema extends BaseModel {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	protected $table = "type_cinema";
	protected $fillable = [
		'name_type_cinema',

	];
	public function film() {
		return $this->hasMany(\App\Models\Films::class, 'id_type_cinema');
	}
	public function type_cinema_user() {
		return $this->hasMany(\App\Models\TypeCinemaUser::class, 'id_type_cinema');
	}

}
