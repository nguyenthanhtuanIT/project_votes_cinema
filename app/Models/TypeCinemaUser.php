<?php

namespace App\Models;

/**
 * Class TypeCinemaUser.
 *
 * @package namespace App\Models;
 */
class TypeCinemaUser extends BaseModel {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $table = "type_cinema_user";
	protected $fillable = [
		'id_users',
		'id_type_cinema',

	];
	public function type_cinema_user() {
		return $this->belongsTo(\App\User::class, 'id_users');
	}
	public function type_cinema() {
		return $this->belongsTo(\App\Models\TypeCinema::class, 'id_type_cinema');
	}
}
