<?php
namespace App\Services;

use App\Models\Films;

class VoteService {
	public static function add($id) {
		$film = Films::find($id);
		$film->vote_number += 1;
		$film->save();
	}

}