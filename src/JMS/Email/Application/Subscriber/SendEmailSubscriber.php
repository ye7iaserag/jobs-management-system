<?php

declare(strict_types=1);

namespace JMS\Email\Application\Subscriber;

use Shared\Domain\Bus\Event\DomainEventSubscriber;
use JMS\Email\Domain\ValueObject\{ EmailId, EmailAddress, EmailSubject ,EmailBody };
use JMS\Auth\Domain\Event\NotifyManagersJobCreated;
use JMS\Email\Application\Service\SendEmailService;

final class SendEmailSubscriber implements DomainEventSubscriber
{
    public function __construct(private SendEmailService $sender)
    {
    }

    public static function subscribedTo(): array
    {
        return [NotifyManagersJobCreated::class];
    }

    public function __invoke(NotifyManagersJobCreated $event): void
    {
        $emails = $event->payload();
        
        $subject = new EmailSubject('New Job Created');
        $body = new EmailBody('A user published a new job');
        array_walk($emails, function (string $email) use ($subject, $body) {
            $this->sender->send(EmailId::random(), new EmailAddress($email), $subject, $body);
        });
    }
}
