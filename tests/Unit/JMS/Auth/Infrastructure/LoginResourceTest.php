<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use JMS\Auth\Application\LoginResponse;
use JMS\Auth\Infrastructure\Http\Resources\LoginResource;
use Tests\TestCase;

final class LoginRequestTest extends TestCase
{
    use WithFaker;

    function test_create_login_resource()
    {
        $resource = new LoginResource(new LoginResponse($this->faker->uuid()));

        $array = $resource->toArray($this->app->make(Request::class));

        dd($array);

        $this->assertIsArray($array);
    }

}
