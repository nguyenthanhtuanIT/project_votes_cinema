<?php

namespace App\Repositories\Eloquent;

use App\Models\TypeCinema;
use App\Presenters\TypeCinemaPresenter;
use App\Repositories\Contracts\TypeCinemaRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class TypeCinemaRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class TypeCinemaRepositoryEloquent extends BaseRepository implements TypeCinemaRepository {
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() {
		return TypeCinema::class;
	}

	/**
	 * Specify Presenter class name
	 *
	 * @return string
	 */
	public function presenter() {
		return TypeCinemaPresenter::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot() {
		$this->pushCriteria(app(RequestCriteria::class));
	}

}
