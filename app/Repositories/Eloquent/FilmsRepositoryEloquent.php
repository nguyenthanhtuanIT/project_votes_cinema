<?php

namespace App\Repositories\Eloquent;

use App\Models\Films;
use App\Presenters\FilmsPresenter;
use App\Repositories\Contracts\filmsRepository;
use Carbon\Carbon;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class FilmsRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class FilmsRepositoryEloquent extends BaseRepository implements FilmsRepository {
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() {
		return Films::class;
	}

	/**
	 * Specify Presenter class name
	 *
	 * @return string
	 */
	public function presenter() {
		return FilmsPresenter::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot() {
		$this->pushCriteria(app(RequestCriteria::class));
	}
	public function create($attributes) {
		$attributes['vote_number'] = 0;
		$attributes['register_number'] = 0;
		$attributes['curency'] = 'đ';
		$film = parent::create($attributes);
		return response()->json($film);
	}
	public function getlistFilm() {
		$time = Carbon::now();
		$films = $this->model()::whereMonth('projection_date', $time->month)->whereYear('projection_date', $time->year)->get();
		return $films;
	}

}
