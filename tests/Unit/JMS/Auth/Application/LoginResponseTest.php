<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Application\LoginResponse;
use JMS\Auth\Domain\ValueObject\JwtToken;
use Tests\TestCase;

final class LoginResponseTest extends TestCase
{
    use WithFaker;

    function test_create_login_response()
    {
        $token = $this->faker->uuid();

        $loginResponse = new LoginResponse($token);

        $this->assertEquals($token, $loginResponse->token());
    }

    function test_create_login_response_from_user()
    {
        $jwtToken = new JwtToken($this->faker->uuid());

        $userResponse = LoginResponse::fromJwtToken($jwtToken);

        $this->assertEquals($jwtToken->value(), $userResponse->token());
    }

    function test_login_to_array()
    {
        $token = $this->faker->uuid();

        $userResponse = new LoginResponse($token);

        $array = $userResponse->toArray();

        $this->assertEquals($token, $array['token']);
    }

}