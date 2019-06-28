<?php

namespace App\Mail;

use App\Models\Vote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailAgree extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $vote = Vote::whereNotIn('status_vote', ['created', 'end'])->first();
        return $this->view('emails.mail_agree')->with('vote', $vote);
    }
}
