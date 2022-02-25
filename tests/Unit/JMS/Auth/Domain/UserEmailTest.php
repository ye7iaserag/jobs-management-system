<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Domain\ValueObject\UserEmail;
use Tests\TestCase;

final class UserEmailTest extends TestCase
{
    use WithFaker;

    function test_create_user_email()
    {
        $email = $this->faker->email();
        $userEmail = new UserEmail($email);

        $this->assertEquals($email, $userEmail->value());
    }

    function test_create_user_email_invalid()
    {
        $this->expectException(\InvalidArgumentException::class);
        new UserEmail($this->faker->name());
    }

}
