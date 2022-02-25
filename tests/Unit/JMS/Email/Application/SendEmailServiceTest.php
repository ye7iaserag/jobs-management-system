<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Email\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Email\Application\Send\SendEmailCommand;
use JMS\Email\Application\Service\SendEmailService;
use JMS\Email\Domain\EmailSender;
use JMS\Email\Domain\ValueObject\EmailAddress;
use JMS\Email\Domain\ValueObject\EmailBody;
use JMS\Email\Domain\ValueObject\EmailId;
use JMS\Email\Domain\ValueObject\EmailSubject;
use Tests\TestCase;

final class SendEmailServiceTest extends TestCase
{
    use WithFaker;

    function test_create_send_email_service()
    {
        $emailId = new EmailId($this->faker->uuid());
        $emailAddress = new EmailAddress($this->faker->email());
        $emailSubject = new EmailSubject($this->faker->name());
        $emailBody = new EmailBody($this->faker->name());

        $this->mock(EmailSender::class, fn ($mock) => $mock->shouldReceive('send')->once());

        $sender = $this->app->make(EmailSender::class);

        $service = new SendEmailService($sender);

        $service->send($emailId, $emailAddress, $emailSubject, $emailBody);
    }

}