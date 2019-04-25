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
	protected $table = "registers";
	protected $fillable = [
		'name_register',
		'user_vote',
		'id_vote',
		'id_films',
		'ticket_number',

	];
	public function user() {
		return $this->belongsTo(\App\User::class, 'user_vote');
	}
	public function vote() {
		return $this->belongsTo(\App\Models\Vote::class, 'id_vote');
	}
	public function film() {
		return $this->belongsTo(\App\Models\Films::class, 'id_films');
	}

}
