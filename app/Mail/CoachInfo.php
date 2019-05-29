<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CoachInfo extends Mailable
{
    use Queueable, SerializesModels;
    public $email, $instagram, $name, $phone;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $email, $phone, $instagram)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->instagram = $instagram;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.coach-info');
    }
}
