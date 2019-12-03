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
    public function __construct(Array $array)
    {
        $this->data = new \stdClass();
        $this->data->mail = $array['mail'];
        $this->data->id_form_repondant = $array['id_form_repondant'];
        $this->data->form_id = $array['form_id'];
        $this->data->user_id = $array['user_id'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to($this->data->mail)
            ->subject('Enquête de satisfaction')
            ->view('mail.repondantlink');
    }
}
