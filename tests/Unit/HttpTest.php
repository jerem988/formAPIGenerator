<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\TestCase;

class HttpTest extends TestCase
{
/**
* A basic test example.
*
* @return void
*/
public function testUrlRacineTest()
{
    $response = $this->get('/user');
    $response->dumpHeaders();
    $response->dump();
    $response->assertStatus(404 , $response->getStatusCode());
}
}
