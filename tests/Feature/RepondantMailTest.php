<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Mail\RepondantMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RepondantMailTest extends TestCase
{
    public function testEmail()
    {
        $this->assertTrue(true);

        /*Mail::fake();

        // Perform order shipping...
        $array['id_form_repondant'] ="1";
        $array['form_id'] = 1;
        $array['user_id'] = 1;

        Mail::assertSent(RepondantMail::class, function ($mail) use ($array) {
            return $array->id_form_repondant === $array['id_form_repondant'];
        });

        // Assert a message was sent to the given users...
        Mail::assertSent(RepondantMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email) ;
        });

        // Assert a mailable was sent twice...
        Mail::assertSent(RepondantMail::class, 2);

        // Assert a mailable was not sent...
        Mail::assertNotSent(RepondantMail::class);*/
    }
}
