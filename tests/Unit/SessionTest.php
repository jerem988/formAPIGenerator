<?php

namespace Tests\Unit;

use Tests\TestCase;

class SessionTest extends TestCase
{
    public function testSessionGuest()
    {
        $response = $this->get('/mes-formulaire');
        $this->assertGuest($guard = null);
    }
}
