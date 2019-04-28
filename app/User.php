<?php

namespace App;

use App\Models\BaseModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends BaseModel implements JWTSubject, AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {
	use Notifiable, EntrustUserTrait, Authenticatable, CanResetPassword;

	const PF_ADMIN = 'web_admin';
	const PF_USER = 'web_user';
	const IMAGE_TYPE = 'user';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	public $timestamps = true;

	protected $fillable = [
		'name',
		'name_signin',
		'password',
		'email',
		'phone',
		'address',
		'sex',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	/**
	 * Update created_at
	 * @param array attributes
	 * @return string
	 */
	public function getCreatedAttribute() {
		return $this->created_at ? $this->created_at->toIso8601String() : '';
	}
	/**
	 * Update update_at
	 * @param array attributes
	 * @return string
	 */
	public function getUpdatedAttribute() {
		return $this->updated_at ? $this->updated_at->toIso8601String() : '';
	}

	/**
	 * Update update_at
	 * @param array attributes
	 * @return string
	 */
	public function getDeletedAttribute() {
		return $this->deleted_at ? $this->deleted_at->toIso8601String() : '';
	}

	/**
	 * Get the identifier that will be stored in the subject claim of the JWT.
	 *
	 * @return mixed
	 */
	public function getJWTIdentifier() {
		return $this->getKey();
	}

	/**
	 * Return a key value array, containing any custom claims to be added to the JWT.
	 *
	 * @return array
	 */
	public function getJWTCustomClaims() {
		return [];
	}

	/**
	 * get roles user
	 * @return array roles
	 */
	public function getRoles() {
		return $this->roles()->orderBy('role_id')->pluck('name')->toArray();
	}

	/**
	 * Define relations images
	 */
	public function image() {
		return $this->hasOne(\App\Models\Image::class, 'object_id')->where('object_type', self::IMAGE_TYPE);
	}

	/**
	 * Define relations images
	 */
	public function tokens() {
		return $this->hasMany(\App\Models\DeviceToken::class, 'user_id');
	}
	public function register() {
		return $this->hasMany(\App\Models\Register::class, 'user_vote');
	}
	public function type_cinema_user() {
		return $this->belongsToMany('\App\Models\TypeCinema', 'type_cinema_user', 'id_users', 'id_type_cinema');
	}
}