<?php

namespace App\Repositories\Eloquent;

use App\Models\Image;
use App\Models\TypeCinema;
use App\Presenters\UserPresenter;
use App\Repositories\Contracts\UserRepository;
use App\Services\RoleService;
use App\User;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository {
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() {
		return User::class;
	}

	public function presenter() {
		return UserPresenter::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot() {
		$this->pushCriteria(app(RequestCriteria::class));
	}

	/**
	 * Override method create to add owners
	 * @param  array  $attributes attributes from request
	 * @return object
	 */
	public function create(array $attributes) {
		$attributes['password'] = bcrypt($attributes['password']);
		$user_1 = parent::create(array_except($attributes, 'role', 'name_type_cinema'));
		$user = User::find($user_1->id);

		//find or create role admin
		if (!empty($attributes['role'])) {
			RoleService::add($user, $attributes['role']);
		}
		$type = TypeCinema::where('name_type_cinema', $attributes['name_type_cinema'])->get();
		$type_cinema = TypeCinema::find($type);
		$user->type_cinema_user()->attach($type_cinema);

		return $user;
	}

	/**
	 * Override method create to add owners
	 * @param  array  $attributes attributes from request
	 * @return object
	 */
	public function update(array $attributes, $id) {
		if (!empty($attributes['password'])) {
			$attributes['password'] = bcrypt($attributes['password']);
		}
		$user = parent::update(array_except($attributes, 'role', 'photo'), $id);

		if (!empty($attributes['role'])) {
			RoleService::sync($user, $attributes['role']);
		}

		if (!empty($attributes['photo'])) {
			if ($user->image) {
				Storage::delete($user->image->pathname);
				Storage::delete('thumbnails/' . $user->image->filename);
				$user->image->delete();
			}
			Image::where('id', $attributes['photo'])->update([
				'object_id' => $user->id,
				'object_type' => User::IMAGE_TYPE,
			]);
		}

		$user = $user->refresh();

		return $user;
	}
}
