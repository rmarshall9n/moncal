<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApplicationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_login()
    {
        $user = factory(\App\User::class)->create();

        $response = $this->actingAs($user)
            ->get('/dashboard');

        $response->assertStatus(200)
            ->assertSeeText('Dashboard');
    }
}
