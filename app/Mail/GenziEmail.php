<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenziEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $password;
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $password = $this->password;
        return $this->from('generasi.zenius.inspiratif@gmail.com')
                   ->view('emailku')
                   ->with(
                    [
                        'user' => $user,
                        'password' => $password
                    ]);
    }
}
