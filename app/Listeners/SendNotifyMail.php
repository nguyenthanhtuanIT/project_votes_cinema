<?php

namespace App\Listeners;

use App\Events\NewVote;
use App\Mail\NotificationMessage;
use Mail;

class SendNotifyMail {
	/**
	 * Create the event listener.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Handle the event.
	 *
	 * @param  NewVote  $event
	 * @return void
	 */
	public function handle(NewVote $event) {
		Mail::to('nguyenthanhtuan.15it@gmail.com')->send(new NotificationMessage($event->vote));
	}
}
