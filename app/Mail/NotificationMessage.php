<?php

namespace App\Mail;

use App\Models\Vote;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMessage extends Mailable {
	use Queueable, SerializesModels;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public $user;
	public function __construct(User $user) {
		$this->user = $user;
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build() {
		$vote = Vote::orderBy('id', 'DESC')->first();
		//dd($vote);
		return $this->view('emails.mail_notification')
			->with('votes', $vote);
	}
}
