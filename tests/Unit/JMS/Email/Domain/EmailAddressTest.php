<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Email\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Email\Domain\ValueObject\EmailAddress;
use Tests\TestCase;

final class EmailAddressTest extends TestCase
{
    use WithFaker;

    function test_create_user_email()
    {
        $email = $this->faker->email();
        $userEmail = new EmailAddress($email);

        $this->assertEquals($email, $userEmail->value());
    }

    function test_create_user_email_invalid()
    {
        $this->expectException(\InvalidArgumentException::class);
        new EmailAddress($this->faker->name());
    }

}
