<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Domain\ValueObject\UserPassword;
use Tests\TestCase;

final class UserPasswordTest extends TestCase
{
    use WithFaker;

    function test_create_user_password()
    {
        $email = $this->faker->email();
        $userEmail = new UserPassword($email);

        $this->assertEquals($email, $userEmail->value());
    }

    function test_create_user_password_min_length()
    {
        $this->expectException(\InvalidArgumentException::class);
        new UserPassword('');
    }

    function test_create_user_password_max_length()
    {
        $this->expectException(\InvalidArgumentException::class);
        new UserPassword(random_bytes(101));
    }

}
