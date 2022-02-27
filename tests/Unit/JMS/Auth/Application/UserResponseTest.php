<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Application\Response\UserResponse;
use JMS\Auth\Domain\Entity\User;
use JMS\Auth\Domain\ValueObject\UserEmail;
use JMS\Auth\Domain\ValueObject\UserId;
use JMS\Auth\Domain\ValueObject\UserPassword;
use JMS\Auth\Domain\ValueObject\UserRole;
use Tests\TestCase;
use Shared\Domain\Enum\Role;

final class UserResponseTest extends TestCase
{
    use WithFaker;

    function test_create_user_response()
    {
        $id = $this->faker->uuid();
        $email = $this->faker->name();

        $userResponse = new UserResponse($id, $email);

        $this->assertEquals($id, $userResponse->id());
        $this->assertEquals($email, $userResponse->email());
    }

    function test_create_user_response_from_user()
    {
        $userId = new UserId($this->faker->uuid());
        $userEmail = new UserEmail($this->faker->email());
        $userPassword = new UserPassword($this->faker->name());
        $userRole = new UserRole(Role::Regular);

        $user = new User($userId, $userEmail, $userPassword, $userRole);

        $userResponse = UserResponse::fromUser($user);

        $this->assertEquals($userId->value(), $userResponse->id());
        $this->assertEquals($userEmail->value(), $userResponse->email());
    }

    function test_user_response_to_array()
    {
        $id = $this->faker->uuid();
        $email = $this->faker->email();

        $userResponse = new UserResponse($id, $email);

        $array = $userResponse->toArray();

        $this->assertEquals($id, $array['id']);
        $this->assertEquals($email, $array['email']);
    }

}