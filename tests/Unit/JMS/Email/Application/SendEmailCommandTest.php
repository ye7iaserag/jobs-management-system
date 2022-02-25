<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Email\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Email\Application\Send\SendEmailCommand;
use Tests\TestCase;

final class SendEmailCommandTest extends TestCase
{
    use WithFaker;

    function test_create_send_email_command()
    {
        $id = $this->faker->uuid();
        $email = $this->faker->email();
        $subject = $this->faker->name();
        $body = $this->faker->name();

        $command = new SendEmailCommand($id, $email, $subject, $body);

        $this->assertEquals($id, $command->id());
        $this->assertEquals($email, $command->email());
        $this->assertEquals($subject, $command->subject());
        $this->assertEquals($body, $command->body());
    }

}