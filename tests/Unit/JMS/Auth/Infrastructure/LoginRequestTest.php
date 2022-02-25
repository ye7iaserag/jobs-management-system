<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Infrastructure\Http\Requests\LoginRequest;
use Tests\TestCase;

final class LoginRequestTest extends TestCase
{
    use WithFaker;

    function test_create_login_request()
    {
        $request = new LoginRequest();

        $isAuthoized = $request->authorize();
        $rules = $request->rules();

        $this->assertIsBool($isAuthoized);
        $this->assertIsArray($rules);
    }

}
