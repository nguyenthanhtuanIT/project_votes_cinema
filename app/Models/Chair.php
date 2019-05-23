<?php

namespace App\Models;

/**
 * Class Chair.
 *
 * @package namespace App\Models;
 */
class Chair extends BaseModel {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['code_chair', 'vote_id', 'row_of_seats', 'number_start', 'number_end'];
	public function getchair() {
		$data[] = array();
		$row = $this->row_of_seats;
		$start = $this->number_start;
		$end = $this->number_end;
		for ($i = $start; $i <= $end; $i++) {
			$data[] = "$row-$i";
			$result = array_slice($data, $start, $end);
		}
		return $result;
	}
}
