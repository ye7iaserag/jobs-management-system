<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Domain\UsersFiltration;
use JMS\Auth\Domain\ValueObject\UserRole;
use Tests\TestCase;
use Shared\Domain\Enum\Role;

final class UsersFiltrationTest extends TestCase
{
    use WithFaker;

    function test_create_users_filtration()
    {
        $userRole = new UserRole(Role::Regular);

        $usersFiltration = new UsersFiltration($userRole);

        $this->assertEquals($userRole->value(), $usersFiltration->role()->value());
    }

}
