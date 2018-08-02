<?php

namespace App\Mail;

use App\User;
use App\Doodle;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Report extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $doodle;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Doodle $doodle)
    {
        $this->user = $user;
        $this->doodle = $doodle;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.report');
    }
}
