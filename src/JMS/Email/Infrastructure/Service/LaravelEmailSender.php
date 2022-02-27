<?php

declare(strict_types=1);

namespace JMS\Email\Infrastructure\Service;

use Exception;
use JMS\Email\Infrastructure\Exception\SendEmailException;
use JMS\Email\Domain\Entity\Email;
use JMS\Email\Domain\Port\EmailSender;
use Illuminate\Support\Facades\Mail;
use JMS\Email\Infrastructure\Mail\BaseMail;

final class LaravelEmailSender implements EmailSender
{

    public function send(Email $email): void
    {
        try {
            $mail = new BaseMail();
            $mail->to($email->email()->value())
                ->subject($email->subject()->value())
                ->html($email->body()->value());

            Mail::send($mail);
        } catch (Exception $exception) {
            throw new SendEmailException(previous: $exception);
        }
    }
}
