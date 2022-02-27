<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Application\Login\LoginQuery;
use JMS\Auth\Application\Login\LoginQueryHandler;
use JMS\Auth\Domain\Entity\User;
use JMS\Auth\Domain\Port\HashService;
use JMS\Auth\Domain\Port\JwtRepository;
use JMS\Auth\Domain\Exception\UserNotFound;
use JMS\Auth\Domain\Port\UserRepository;
use JMS\Auth\Domain\ValueObject\JwtToken;
use Shared\Domain\Enum\Role;
use Tests\TestCase;

final class LoginQueryHandlerTest extends TestCase
{
    use WithFaker;

    function test_create_login_query_handler()
    {
        $uuid = $this->faker->uuid();
        $token = $this->faker->uuid();
        $user = User::fromPrimitives($uuid, $this->faker->email(), $this->faker->name(), Role::Regular->value);

        $this->mock(UserRepository::class, fn ($mock) => $mock->shouldReceive('findByEmail')->once()->andReturn($user));
        $this->mock(JwtRepository::class, fn ($mock) => $mock->shouldReceive('getToken')->once()->andReturn(new JwtToken($token)));
        $this->mock(HashService::class, fn ($mock) => $mock->shouldReceive('check')->once()->andReturn(true));

        $userRepoMock = $this->app->make(UserRepository::class);
        $jwtRepoMock = $this->app->make(JwtRepository::class);
        $hashServiceMock = $this->app->make(HashService::class);

        $query = new LoginQuery($this->faker->email(), $this->faker->name());

        $handler = new LoginQueryHandler($userRepoMock, $jwtRepoMock, $hashServiceMock);

        $response = $handler($query);

        $this->assertEquals($response->toArray()['token'], $token);
    }

    function test_create_login_query_handler_email_not_found()
    {
        $uuid = $this->faker->uuid();
        $user = User::fromPrimitives($uuid, $this->faker->email(), $this->faker->name(), Role::Regular->value);

        $this->mock(UserRepository::class, fn ($mock) => $mock->shouldReceive('findByEmail')->once()->andReturn(null));

        $this->expectException(UserNotFound::class);

        $hashServiceMock = $this->app->make(HashService::class);

        $query = new LoginQuery($this->faker->email(), $this->faker->name());
        $userRepoMock = $this->app->make(UserRepository::class);
        $jwtRepoMock = $this->app->make(JwtRepository::class);

        $handler = new LoginQueryHandler($userRepoMock, $jwtRepoMock, $hashServiceMock);

        $handler($query);
    }

    function test_create_login_query_handler_password_mismatch()
    {
        $uuid = $this->faker->uuid();
        $user = User::fromPrimitives($uuid, $this->faker->email(), $this->faker->name(), Role::Regular->value);

        $this->mock(UserRepository::class, fn ($mock) => $mock->shouldReceive('findByEmail')->once()->andReturn($user));
        $this->mock(HashService::class, fn ($mock) => $mock->shouldReceive('check')->once()->andReturn(false));

        $this->expectException(UserNotFound::class);

        $userRepoMock = $this->app->make(UserRepository::class);
        $jwtRepoMock = $this->app->make(JwtRepository::class);
        $hashServiceMock = $this->app->make(HashService::class);

        $query = new LoginQuery($this->faker->email(), $this->faker->name());

        $handler = new LoginQueryHandler($userRepoMock, $jwtRepoMock, $hashServiceMock);

        $handler($query);
    }

}