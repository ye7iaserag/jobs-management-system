<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Shared\Infrastructure\Bus\Messenger\RabbitMQConnectionFactory;
use Shared\Infrastructure\Bus\Messenger\RabbitMQSenderLocator;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Envelope;

final class RabbitMQSenderLocatorTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factoryMock = $this->mock(RabbitMQConnectionFactory::class, fn ($mock) => $mock->shouldReceive('getSender')->once()->andReturn(null));
    }

    function test_rabbitmq_sender_locator()
    {
        $senderLocator = new RabbitMQSenderLocator($this->factoryMock);

        $senderArr = $senderLocator->getSenders(new Envelope(new \stdClass));

        $this->assertIsArray($senderArr);
    }
}
