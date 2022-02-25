<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Application\LoginResponse;
use JMS\Auth\Infrastructure\Http\Controllers\LoginController;
use JMS\Auth\Infrastructure\Http\Requests\LoginRequest;
use Shared\Domain\Bus\Query\QueryBus;
use Tests\TestCase;

final class LoginControllerTest extends TestCase
{
    use WithFaker;

    function test_create_login_controller()
    {
        $this->mock(QueryBus::class, fn ($mock) => $mock->shouldReceive('ask')->once()->andReturn(new LoginResponse($this->faker->uuid())));

        $this->mock(LoginRequest::class, fn ($mock) => $mock->shouldReceive('get')->with('email')->andReturn($this->faker->email())
        ->shouldReceive('get')->with('password')->andReturn($this->faker->name()));

        $queryBus = $this->app->make(QueryBus::class);

        $request = $this->app->make(LoginRequest::class);

        $controller = new LoginController($queryBus);

        $controller($request);

        //do something with response
    }

}
