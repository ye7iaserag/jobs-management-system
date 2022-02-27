<?php

declare(strict_types=1);

namespace JMS\Email\Application\Service;

use JMS\Email\Domain\Entity\Email;
use JMS\Email\Domain\ValueObject\ { EmailId, EmailAddress, EmailSubject, EmailBody };
use JMS\Email\Domain\Port\EmailSender;

final class SendEmailService
{

    public function __construct(private EmailSender $sender)
    {
    }

    public function send(EmailId $id, EmailAddress $email, EmailSubject $subject, EmailBody $body): void
    {
        $mail = new Email($id, $email, $subject, $body);
        $this->sender->send($mail);
    }
}
