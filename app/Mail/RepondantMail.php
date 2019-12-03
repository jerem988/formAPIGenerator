<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RepondantMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The data.
     *
     * @var data
     */

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to("jerem98@gmail.com")
            ->subject('Enquête de satisfaction')
            ->view('mail.repondantlink');
    }
}
