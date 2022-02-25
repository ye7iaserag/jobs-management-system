<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Application\ListUsers\ListUsersQuery;
use JMS\Auth\Application\ListUsers\ListUsersQueryHandler;
use JMS\Auth\Domain\Entity\User;
use JMS\Auth\Domain\UserRepository;
use JMS\Auth\Domain\Users;
use JMS\Auth\Domain\UsersFiltration;
use JMS\Auth\Domain\ValueObject\UserRole;
use Shared\Domain\Enum\Role;
use Tests\TestCase;

final class ListUsersQueryHandlerTest extends TestCase
{
    use WithFaker;

    function test_create_get_job_by_id_query_handler()
    {
        $uuid = $this->faker->uuid();
        $this->mock(UserRepository::class, fn ($mock) => $mock->shouldReceive('list')->once()->andReturn(new Users ([User::fromPrimitives($uuid, $this->faker->email(), $this->faker->name(), Role::Regular->value)])));

        $userRepoMock = $this->app->make(UserRepository::class);

        $query = new ListUsersQuery(new UsersFiltration(new UserRole(Role::Regular)));

        $handler = new ListUsersQueryHandler($userRepoMock);

        $response = $handler($query);

        $this->assertEquals($response->toArray()[0]['id'], $uuid);
    }

}