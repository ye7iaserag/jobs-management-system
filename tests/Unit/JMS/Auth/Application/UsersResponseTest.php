<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Application\Response\UserResponse;
use JMS\Auth\Application\Response\UsersResponse;
use JMS\Auth\Domain\Entity\User;
use JMS\Auth\Domain\DTO\Users;
use JMS\Auth\Domain\ValueObject\UserEmail;
use JMS\Auth\Domain\ValueObject\UserId;
use JMS\Auth\Domain\ValueObject\UserPassword;
use JMS\Auth\Domain\ValueObject\UserRole;
use Tests\TestCase;
use Shared\Domain\Enum\Role;

final class UsersResponseTest extends TestCase
{
    use WithFaker;

    function test_create_users_response()
    {
        $id = $this->faker->uuid();
        $email = $this->faker->email();

        $userResponseArr = [];

        $userResponseArr[] = new UserResponse($id, $email);
        $userResponseArr[] = new UserResponse($id, $email);

        $usersResponse = new UsersResponse($userResponseArr);

        $this->assertEquals(count($userResponseArr), count($usersResponse->toArray()));
    }

    function test_create_users_response_from_user()
    {
        $userId = new UserId($this->faker->uuid());
        $userEmail = new UserEmail($this->faker->email());
        $userPassword = new UserPassword($this->faker->name());
        $userRole = new UserRole(Role::Regular);

        $userArr = [];
        $userArr[] = new User($userId, $userEmail, $userPassword, $userRole);
        $userArr[] = new User($userId, $userEmail, $userPassword, $userRole);

        $usersResponse = UsersResponse::fromUsers(new Users($userArr));

        $this->assertEquals(count($userArr), count($usersResponse->toArray()));
    }

}