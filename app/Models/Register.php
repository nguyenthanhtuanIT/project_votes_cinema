<?php

namespace App\Models;

/**
 * Class Register.
 *
 * @package namespace App\Models;
 */
class Register extends BaseModel {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name_register', 'user_vote', 'id_vote',
		'id_films', 'ticket_number'];

}
