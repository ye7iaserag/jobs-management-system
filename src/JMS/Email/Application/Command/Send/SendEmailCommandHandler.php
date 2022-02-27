<?php

declare(strict_types=1);

namespace JMS\Email\Application\Command\Send;

use Shared\Domain\Bus\Command\CommandHandler;
use JMS\Email\Domain\ValueObject\{ EmailId, EmailAddress, EmailSubject, EmailBody };
use JMS\Email\Application\Service\SendEmailService;

final class SendEmailCommandHandler implements CommandHandler
{
    private SendEmailService $service;

    public function __construct(SendEmailService $service)
    {
        $this->service = $service;
    }

    public function __invoke(SendEmailCommand $command): void
    {
        $id = new EmailId($command->id());
        $email = new EmailAddress($command->email());
        $subject = new EmailSubject($command->subject());
        $body = new EmailBody($command->body());

        $this->service->send($id, $email, $subject, $body);
    }
}
