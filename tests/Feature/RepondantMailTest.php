<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Mail\RepondantMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RepondantMailTest extends TestCase
{
    public function testEmail()
    {
        Mail::fake();

        // Assert that no mailables were sent...
        //Mail::assertNothingSent();

        $array = Array();
        $array['mail'] = "jerem98@gmail.com";
        $array['id_form_repondant'] ="1";
        $array['form_id'] = 1;
        $array['user_id'] = 1;

        $repondant_mail = new RepondantMail($array);

        // Assert a message was sent to the given users...
        Mail::assertSent($repondant_mail, function ($mail) use ($array){
            return $mail->hasTo($array['mail']);
        });

        // Assert a mailable was sent twice...
        //Mail::assertSent(MailController::class, 2);
    }
}
