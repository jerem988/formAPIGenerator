<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;
use App\User;

class SessionTest extends TestCase
{
    public function testApplication()
    {
        $response = $this->get('/mes-formulaire');
        $this->assertGuest($guard = null);
    }
}
