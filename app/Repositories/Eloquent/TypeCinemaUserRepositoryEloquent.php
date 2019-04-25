<?php

namespace App\Repositories\Eloquent;

use App\Models\TypeCinemaUser;
use App\Presenters\TypeCinemaUserPresenter;
use App\Repositories\Contracts\TypeCinemaUserRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class TypeCinemaUserRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class TypeCinemaUserRepositoryEloquent extends BaseRepository implements TypeCinemaUserRepository {
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() {
		return TypeCinemaUser::class;
	}

	/**
	 * Specify Presenter class name
	 *
	 * @return string
	 */
	public function presenter() {
		return TypeCinemaUserPresenter::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot() {
		$this->pushCriteria(app(RequestCriteria::class));
	}

}
