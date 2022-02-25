<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Event;

use Shared\Domain\ValueObject\UuidValueObject;
use DateTimeImmutable;

abstract class DomainEvent
{
    private string $aggregateId;
    private array $payload;
    private string $eventId;
    private string $occurredOn;

    public function __construct(string $aggregateId, array $payload = [], string $eventId = null, string $occurredOn = null)
    {
        $this->aggregateId = $aggregateId;
        $this->eventId    = $eventId ?: UuidValueObject::random()->value();
        $this->payload = $payload;
        $this->occurredOn = $occurredOn ?: (new DateTimeImmutable())->format('Y-m-d H:i:s.u T');
    }

    abstract public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): self;

    abstract public static function eventName(): string;

    abstract public function toPrimitives(): array;

    public function aggregateId(): string
    {
        return $this->aggregateId;
    }

    public function eventId(): string
    {
        return $this->eventId;
    }

    public function payload(): array
    {
        return $this->payload;
    }

    public function occurredOn(): string
    {
        return $this->occurredOn;
    }
}
