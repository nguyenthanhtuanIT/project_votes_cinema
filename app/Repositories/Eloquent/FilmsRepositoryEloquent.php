<?php

namespace App\Repositories\Eloquent;

use App\Models\Films;
use App\Models\Vote;
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
	public function maxVoteNumber() {
		$vote = Vote::where('status_vote', 2)->select('id', 'status_vote')->first();
		$max = $this->model()::where('vote_id', $vote->id)->max('vote_number');
		$film = $this->model()::where('vote_id', $vote->id)->where('vote_number', $max)->get();
		return $film;
	}
	public function searchFilms($keyword) {
		$data = $this->model()::where('projection_date', $keyword)->orwhere('type_cinema_id', $keyword)->get();
		return $data;
	}

}
