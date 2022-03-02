<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Shared\Domain\Bus\Event\ConnectionFactory;
use Shared\Infrastructure\Bus\Messenger\CallableFirstParameterExtractor;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Transport\Receiver\QueueReceiverInterface;
use Tests\TestCase;
use Symfony\Component\Messenger\Envelope;

final class RabbitMQConsumeCommandTest extends TestCase
{
    use WithFaker;

    private $mock;

    function test_rabbitmq_consume_command()
    {
        $mock = $this->mock(ConnectionFactory::class, fn ($mock) => $mock->shouldReceive('makeHandleMessageMiddleware')->once()->andReturn(
            new HandleMessageMiddleware(
                new HandlersLocator(
                    CallableFirstParameterExtractor::forPipedCallables([])
                )
            )
        )->shouldReceive('getReceiver')->once()->andReturn(new class implements QueueReceiverInterface {
            public function getFromQueues(array $queueNames): iterable {return [];}
            public function get(): iterable {return [];}
            public function ack(Envelope $envelope): void {}
            public function reject(Envelope $envelope): void {}
        }));

        $this->app->instance(ConnectionFactory::class, $mock);

        $this->artisan('rabbitmq:consume 1')->assertSuccessful();
    }
}
