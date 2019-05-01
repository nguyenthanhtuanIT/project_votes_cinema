<?php

namespace App\Repositories\Eloquent;

use App\Models\Vote;
use App\Presenters\VotePresenter;
use App\Repositories\Contracts\VoteRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class VoteRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class VoteRepositoryEloquent extends BaseRepository implements VoteRepository {
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() {
		return Vote::class;
	}

	/**
	 * Specify Presenter class name
	 *
	 * @return string
	 */
	public function presenter() {
		return VotePresenter::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot() {
		$this->pushCriteria(app(RequestCriteria::class));
	}

}
