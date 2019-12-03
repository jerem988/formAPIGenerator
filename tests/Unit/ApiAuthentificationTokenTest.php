<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
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
        //Création d'un utilisateur fictif
        $user = new User();
        $user->name = Str::random(10);
        $user->email = Str::random(10).'@gmail.com';
        $user->password = bcrypt('password');
        $user->api_token = Str::random(80);
        $user->save();

        //Test d'une adresse de l'api avec un api_token user / header attendu json
        $url = env('APP_URL')."/api/formulaires?api_token=".$user->api_token;

        $this->json('GET', $url)
            ->assertStatus(200)
            ->assertHeader("content-type", "application/json");

        //Supression de l'utilisateur
        $user->delete();
    }
}
