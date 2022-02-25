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
use JMS\Email\Infrastructure\LaravelEmailSender;
use Tests\TestCase;
use JMS\Email\Infrastructure\SendEmailException;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Testing\Fakes\MailFake;
use JMS\Email\Infrastructure\Mail\BaseMail;

final class BaseMailTest extends TestCase
{
    use WithFaker;

    function test_base_mail_build()
    {
        $mail = new BaseMail();

        $result = $mail->build();

        $this->assertInstanceOf(BaseMail::class, $result);
    }

}