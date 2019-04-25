<?php

namespace App\Models;

/**
 * Class Vote.
 *
 * @package namespace App\Models;
 */
class Vote extends BaseModel {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $table = "votes";
	protected $fillable = [
		'name_vote',
		'id_user',
		'status_vote',
		'detail',
		'deadline',

	];
	public function register() {
		return $this->hasMany(\App\Models\Register::class, 'id_vote');
	}
	public function film() {
		return $this->hasMany(\App\Models\Films::class, 'id_vote');
	}

}
