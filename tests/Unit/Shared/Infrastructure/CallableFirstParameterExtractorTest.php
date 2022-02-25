<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\Bus\Event\DomainEventSubscriber;
use Shared\Domain\Bus\Query\Query;
use Shared\Domain\Bus\Query\QueryHandler;
use Shared\Domain\Bus\Query\Response;
use Tests\TestCase;
use Shared\Infrastructure\Bus\Messenger\CallableFirstParameterExtractor;

class EventExample2 extends DomainEvent
{
    public static function fromPrimitives(
        string $aggregateId,
        array $body,
        string $eventId,
        string $occurredOn
    ): self {
        return new EventExample2($aggregateId, $body, $eventId, $occurredOn);
    }
    public static function eventName(): string
    {
        return 'test_event2';
    }
    public function toPrimitives(): array
    {
        return [];
    }
}
class SubscriberExample2 implements DomainEventSubscriber
{
    public static function subscribedTo(): array
    {
        return [EventExample2::class];
    }
}

final class CallableFirstParameterExtractorTest extends TestCase
{
    use WithFaker;

    function test_first_parameter_extractor_for_piped_callables()
    {
        $result = CallableFirstParameterExtractor::forPipedCallables([new SubscriberExample2]);

        $this->assertIsArray($result);
    }

    function test_first_parameter_extractor__extract()
    {
        $extractor = new CallableFirstParameterExtractor();

        $result = $extractor->extract(new class {public function __invoke(EventExample2 $event){}});

        $this->assertEquals(EventExample2::class, $result);
    }

    function test_first_parameter_extractor__extract_null()
    {
        $extractor = new CallableFirstParameterExtractor();

        $result = $extractor->extract(new class {public function __invoke(){}});

        $this->assertNull($result);
    }
    
}
