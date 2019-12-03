<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Mail\RepondantMail;
use Illuminate\Support\Facades\Mail;

class RepondantMailTest extends TestCase
{

    public function testEmail()
    {
        //Fake mail
        Mail::fake();

        // Tester qu'aucun e-mail  n'est encore partie
        Mail::assertNothingSent();

        //Data du constructeur Mailable
        $data = new \stdClass();

        //Données email de test
        $data->mail = "jerem98@gmail.com";
        $data->id_form_repondant ="1";
        $data->form_id = 1;
        $data->user_id = 1;

        //Instance de la classe Mailable
        $mailable = new RepondantMail($data);

        //Envoyer le fake mail
        Mail::to($data->mail)->send($mailable);

        // Tester que le mail à été envoyé au bon destinataire
        Mail::assertSent(RepondantMail::class, function ($mail) use ($data){
            return  $mail->hasTo($data->mail);
        });

        // Mail envoyé une fois seulement
        Mail::assertSent(RepondantMail::class, 1);
    }
}
