<?php

declare(strict_types=1);

namespace JMS\Job\Domain\Event;

use Shared\Domain\Bus\Event\DomainEvent;

final class JobCreated extends DomainEvent
{

    const EVENT_NAME = 'job_created';

    public static function fromPrimitives(
        string $aggregateId,
        array $payload,
        string $eventId,
        string $occurredOn
    ): self
    {
        return new JobCreated($aggregateId,
        $payload,
        $eventId,
        $occurredOn);
    }

    public static function eventName(): string {
        return JobCreated::EVENT_NAME;
    }

    public function toPrimitives(): array {
        return [$this->aggregateId(), $this->payload(), $this->eventId(), $this->occurredOn()];
    }
}
