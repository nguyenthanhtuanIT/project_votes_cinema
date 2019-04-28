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
	public $timestamps = true;
	protected $fillable = [
		'id_users',
		'id_type_cinema',
	];

}
