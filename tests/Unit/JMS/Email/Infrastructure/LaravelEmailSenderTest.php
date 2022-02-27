<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Email\Infrastructure;

use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Foundation\Testing\WithFaker;
use JMS\Email\Domain\Entity\Email;
use JMS\Email\Domain\ValueObject\EmailAddress;
use JMS\Email\Domain\ValueObject\EmailBody;
use JMS\Email\Domain\ValueObject\EmailId;
use JMS\Email\Domain\ValueObject\EmailSubject;
use JMS\Email\Infrastructure\Service\LaravelEmailSender;
use Tests\TestCase;
use JMS\Email\Infrastructure\Exception\SendEmailException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Testing\Fakes\MailFake;

final class LaravelEmailSenderTest extends TestCase
{
    use WithFaker;

    function test_laravel_email_sender_send()
    {
        Mail::fake();

        $emailId = new EmailId($this->faker->uuid());
        $emailAddress = new EmailAddress($this->faker->email());
        $emailSubject = new EmailSubject($this->faker->name());
        $emailBody = new EmailBody($this->faker->name());

        $email = new Email($emailId, $emailAddress, $emailSubject, $emailBody);

        $sender = new LaravelEmailSender();

        $sender->send($email);

        Mail::assertSent(Mailable::class, fn ($mail) =>
            $mail->hasTo($emailAddress->value()) && $mail->subject === $emailSubject->value()
        );
    }

    function test_laravel_email_sender_send_failure()
    {
        $mock = $this->mock(MailFake::class, fn ($mock) => $mock->shouldReceive('send')->once()->andThrow(new \Exception()));
        Mail::swap($mock);

        $emailId = new EmailId($this->faker->uuid());
        $emailAddress = new EmailAddress($this->faker->email());
        $emailSubject = new EmailSubject($this->faker->name());
        $emailBody = new EmailBody($this->faker->name());

        $email = new Email($emailId, $emailAddress, $emailSubject, $emailBody);

        $sender = new LaravelEmailSender();

        $this->expectException(SendEmailException::class);

        $sender->send($email);
    }

}