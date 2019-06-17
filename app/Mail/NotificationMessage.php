<?php

namespace App\Mail;

use App\Models\Vote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotificationMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    // public $user;
    // public function __construct(User $user)
    // {
    //     $this->user = $user;
    // }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $vote = Vote::where('status_vote', 'voting')->first();
        //dd($vote);
        return $this->view('emails.mail_notification')
            ->with('votes', $vote);
    }
}
