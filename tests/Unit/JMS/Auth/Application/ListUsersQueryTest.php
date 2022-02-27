<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Application\ListUsers\ListUsersQuery;
use JMS\Auth\Domain\DTO\UsersFiltration;
use JMS\Auth\Domain\ValueObject\UserRole;
use Shared\Domain\Enum\Role;
use Tests\TestCase;

final class ListUsersQueryTest extends TestCase
{
    use WithFaker;

    function test_create_list_users_query()
    {
        $query = new ListUsersQuery(new UsersFiltration(new UserRole(Role::Regular)));

        $this->assertNotNull($query->filtration());
    }

}