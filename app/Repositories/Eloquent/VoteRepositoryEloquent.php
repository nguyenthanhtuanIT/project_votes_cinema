<?php

namespace App\Repositories\Eloquent;

use App\Models\Vote;
use App\Presenters\VotePresenter;
use App\Repositories\Contracts\VoteRepository;
use Mail;
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
	public function search($title) {
		$result = $this->model()::where('name_vote', 'like', '%' . $title . '%')->get();
		return $result;
	}
	public function create(array $attributes) {
		$vote = parent::create($attributes);
		$data = [];
		Mail::send('emails.mail_notification', $data, function ($msg) {
			$msg->from('shopmoto224@gmail.com', 'Hệ thống');
			$msg->to("duongdosieu224@gmail.com", 'Công đoàn')->subject('mail_notification');
		});
		return $vote;
	}
}
