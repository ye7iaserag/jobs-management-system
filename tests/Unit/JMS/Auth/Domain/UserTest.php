<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Domain\Entity\User;
use Tests\TestCase;
use JMS\Auth\Domain\ValueObject\{ UserId, UserEmail, UserPassword, UserRole };
use Shared\Domain\Enum\Role;

final class UserTest extends TestCase
{
    use WithFaker;

    function test_create_user()
    {
        $userId = new UserId($this->faker->uuid());
        $userEmail = new UserEmail($this->faker->email());
        $userPassword = new UserPassword($this->faker->name());
        $userRole = new UserRole(Role::Regular);

        $user = new User($userId, $userEmail, $userPassword, $userRole);

        $this->assertEquals($userId->value(), $user->id()->value());
        $this->assertEquals($userEmail->value(), $user->email()->value());
        $this->assertEquals($userPassword->value(), $user->password()->value());
        $this->assertEquals($userRole->value(), $user->role()->value());
    }

    function test_hydrate_user()
    {
        $id = $this->faker->uuid();
        $email = $this->faker->email();
        $password = $this->faker->name();
        $role = Role::Regular;

        $user = User::fromPrimitives($id, $email, $password, $role->value);

        $this->assertEquals($id, $user->id()->value());
        $this->assertEquals($email, $user->email()->value());
        $this->assertEquals($password, $user->password()->value());
        $this->assertEquals($role, $user->role()->value());
    }
    
}
