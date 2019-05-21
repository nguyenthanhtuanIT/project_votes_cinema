<?php

namespace App\Exports;

use App\Models\Films;
use App\Models\Register;
use App\Models\Vote;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RegistersExport implements FromCollection, WithHeadings {
	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function getUsers() {
		$register = Register::all();
		$user = User::all();
		foreach ($register as $r) {
			foreach ($user as $u) {
				if ($r->user_id == $u->id) {
					$name = $u->full_name;
				}
			}
		}
		return $name;
	}
	public function getEmails() {
		$register = Register::all();
		$user = User::all();
		foreach ($register as $r) {
			foreach ($user as $u) {
				if ($r->user_id == $u->id) {
					$email = $u->email;
				}
			}
		}
		return $email;
	}
	public function getVotes() {
		$register = Register::all();
		$votes = Vote::all();
		foreach ($register as $r) {
			foreach ($votes as $v) {
				if ($r->vote_id == $v->id) {
					$vote = $v->name_vote;
				}
			}
		}
		return $vote;
	}
	public function getFilms() {
		$register = Register::all();
		$films = Films::all();
		foreach ($register as $r) {
			foreach ($films as $f) {
				if ($r->film_id == $f->id) {
					$film = $f->name_film;
				}
			}
		}
		return $film;
	}
	public function collection() {
		$register = Register::all();
		if (count($register) > 0) {
			foreach ($register as $reg) {
				$data[] = array(
					'0' => $reg->name_register,
					'1' => $this->getUsers(),
					'2' => $this->getEmails(),
					'3' => $this->getVotes(),
					'4' => $this->getFilms(),
					'5' => $reg->ticket_number);
			}
			return (collect($data));
		} else {
			$data[] = array();
			return (collect($data));
		}

	}
	public function headings(): array
	{
		return [
			'Name_register',
			'Name',
			'Email',
			'Name_vote',
			'Name_film',
			'Ticket_number',
		];
	}
}
