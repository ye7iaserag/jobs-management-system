<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Email\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Email\Application\Command\Send\SendEmailCommand;
use JMS\Email\Application\Command\Send\SendEmailCommandHandler;
use JMS\Email\Application\Service\SendEmailService;
use Tests\TestCase;

final class SendEmailCommandHandlerTest extends TestCase
{
    use WithFaker;

    function test_create_send_email_command_handler()
    {
        $id = $this->faker->uuid();
        $email = $this->faker->email();
        $subject = $this->faker->name();
        $body = $this->faker->name();

        $this->mock(SendEmailService::class, fn ($mock) => $mock->shouldReceive('send')->once());

        $service = $this->app->make(SendEmailService::class);

        $command = new SendEmailCommand($id, $email, $subject, $body);

        $handler = new SendEmailCommandHandler($service);

        $handler($command);
    }

}