<?php

namespace App\Models;

use App\Models\Films;
use App\Models\Vote;
use App\User;

/**
 * Class VoteDetails.
 *
 * @package namespace App\Models;
 */
class VoteDetails extends BaseModel {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['id_user', 'id_film', 'id_vote'];

	public function getFilm() {

		$film = Films::find($this->id_film)->select('*')->get();
		return $film;
	}
	public function getName() {

		$user = User::find($this->id_user)->value('name');
		return $user;
	}
	public function getVote() {

		$vote = Vote::find($this->id_vote)->value('name_vote');
		return $vote;
	}
}
