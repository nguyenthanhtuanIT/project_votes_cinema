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
	public function create(array $attributes) {
		$attributes['status_vote'] = 0;
		$votes = parent::create($attributes);
		return $votes;
	}
	public function search($title) {
		$result = $this->model()::where('name_vote', 'like', '%' . $title . '%')->get();
		return $result;
	}
	// public function create(array $attributes) {
	// 	$vote = parent::create($attributes);
	// 	$user = User::all();
	// 	foreach ($user as $us) {
	// 		$email = new NotificationMessage($us);
	// 		Mail::to($us->email)->send($email);
	// 	}

	// 	return $vote;
	// }
	public function getStatusVote() {
		$vote = $this->model()::where('status_vote', 1)->orwhere('status_vote', 2)->get();
		return $vote;
	}
}
