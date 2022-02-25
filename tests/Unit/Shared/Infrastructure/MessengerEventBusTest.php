<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Shared\Infrastructure\Bus\Messenger\MessengerEventBus;
use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\Bus\Event\DomainEventSubscriber;
use Shared\Infrastructure\Bus\Messenger\CallableFirstParameterExtractor;
use Shared\Infrastructure\Bus\Messenger\RabbitMQConnectionFactory;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

class EventExample extends DomainEvent
{
    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): self {
        return new EventExample($aggregateId, $body, $eventId, $occurredOn);
    }
    public static function eventName(): string
    {
        return 'test_event';
    }
    public function toPrimitives(): array
    {
        return [];
    }
}
class SubscriberExample implements DomainEventSubscriber
{
    public static function subscribedTo(): array
    {
        return [EventExample::class];
    }
}

final class MessengerEventBusTest extends TestCase
{
    use WithFaker;

    private $mock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mock = $this->mock(RabbitMQConnectionFactory::class, fn ($mock) => $mock->shouldReceive('makeSendMessageMiddleware')->once()->andReturn(
            new HandleMessageMiddleware(
                    new HandlersLocator(
                        CallableFirstParameterExtractor::forPipedCallables([])
                    )
                )
        ));
    }

    function test_messenger_event_bus_publish()
    {
        
        $queryBus = new MessengerEventBus([new SubscriberExample], $this->mock);

        $queryBus->publish(new EventExample($this->faker->uuid()));

    }


}
