<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HelloEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     protected $userName;
    protected $code;
    protected $email;

    public function __construct($userName, $code,$email)
    {
        //
         $this->userName = $userName;
        $this->code = $code;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       
        return $this->from("kosakishin06@gmail.com")
                    ->view('email-template')
                    ->with([
                        'userName' => $this->userName,
                        'code' => $this->code,
                        'email' => $this->email,
                    ]);
    }
}