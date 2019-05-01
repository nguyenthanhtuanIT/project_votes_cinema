<?php

namespace App\Repositories\Eloquent;

use App\Models\VoteDetails;
use App\Presenters\VoteDetailsPresenter;
use App\Repositories\Contracts\VoteDetailsRepository;
use App\Services\VoteService;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class VoteDetailsRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent;
 */
class VoteDetailsRepositoryEloquent extends BaseRepository implements VoteDetailsRepository {
	/**
	 * Specify Model class name
	 *
	 * @return string
	 */
	public function model() {
		return VoteDetails::class;
	}

	/**
	 * Specify Presenter class name
	 *
	 * @return string
	 */
	public function presenter() {
		return VoteDetailsPresenter::class;
	}

	/**
	 * Boot up the repository, pushing criteria
	 */
	public function boot() {
		$this->pushCriteria(app(RequestCriteria::class));
	}

	public function create(array $attributes) {
		$VoteDetails = parent::create($attributes);
		//	var_dump($VoteDetails['data']['attributes']['id_film']);
		VoteService::add($VoteDetails['data']['attributes']['id_film']);
		return $VoteDetails;

	}

}
