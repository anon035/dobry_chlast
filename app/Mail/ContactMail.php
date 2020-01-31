<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $surname;
    public $email;
    public $body;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $surname, $email, $body)
    {
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->body = $body;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->replyTo($this->email)
            ->subject('New message from contact form!')
            ->view('mail.contact');
    }
}
