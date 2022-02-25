<?php

declare(strict_types=1);

namespace JMS\Auth\Domain\Event;

use Shared\Domain\Bus\Event\DomainEvent;

final class NotifyManagersJobCreated extends DomainEvent
{

    const EVENT_NAME = 'job_created_email';

    public static function fromPrimitives(
        string $aggregateId,
        array $payload,
        string $eventId,
        string $occurredOn
    ): self
    {
        return new NotifyManagersJobCreated($aggregateId,
        $payload,
        $eventId,
        $occurredOn);
    }

    public static function eventName(): string {
        return NotifyManagersJobCreated::EVENT_NAME;
    }

    public function toPrimitives(): array {
        return [$this->aggregateId(), $this->payload(), $this->eventId(), $this->occurredOn()];
    }
}
