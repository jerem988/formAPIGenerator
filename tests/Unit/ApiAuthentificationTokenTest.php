<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate;
use Illuminate\Support\Str;

class ApiAuthentificationTokenTest extends TestCase
{
    public function testAuthentificationWithoutToken()
    {
        $url = env('APP_URL')."/api/formulaires";

        $this->json('GET', $url)
            ->assertStatus(401)
            ->assertExactJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    public function testAuthentificationWithToken()
    {
        //FAUX TOKEN

        $url = env('APP_URL')."/api/formulaires?api_token=". Str::random(30);

        $this->json('GET', $url)
            ->assertStatus(401)
            ->assertExactJson([
                'message' => 'Unauthenticated.'
            ]);

        /* Test d'une adresse de l'api avec un api_token de la l'utilisateur venant d'être créé */

        //Création d'un utilisateur fictif
        $user = factory('App\User')->create();

        //dd($user);

        // VRAI TOKEN
        $url = env('APP_URL')."/api/formulaires?api_token=".$user->api_token;

        $this->json('GET', $url)
            ->assertStatus(200)
            ->assertHeader("content-type", "application/json");

        //Supression de l'utilisateur
        $user->delete();
    }
}
