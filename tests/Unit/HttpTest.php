<?php

namespace Tests\Unit;

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
    $response->assertStatus(404 , $response->getStatusCode());
}
}
