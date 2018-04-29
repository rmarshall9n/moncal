<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function getAuthenticatedResponse()
    {
        $user = factory(\App\User::class)->create();
        return $this->actingAs($user);
    }
}
