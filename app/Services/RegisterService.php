<?php
namespace App\Services;

use App\Models\Films;

class RegisterService {
	public static function add($id, $number) {
		$film = Films::find($id);
		$film->register_number = 1 + $number;
		$film->save();
	}
}