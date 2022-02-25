<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Shared\Infrastructure\Bus\Messenger\RabbitMQConnectionFactory;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpReceiver;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpSender;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;


final class RabbitMQConnectionFactoryTest extends TestCase
{
    use WithFaker;

    function test_rabbitmq_connection_factory_make_send_message_middleware()
    {
        $factory = new RabbitMQConnectionFactory();

        $middleware = $factory->makeSendMessageMiddleware();

        $this->assertInstanceOf(MiddlewareInterface::class, $middleware);
    }

    function test_rabbitmq_connection_factory_make_handle_message_middleware()
    {
        $factory = new RabbitMQConnectionFactory();

        $middleware = $factory->makeHandleMessageMiddleware();

        $this->assertInstanceOf(MiddlewareInterface::class, $middleware);
    }

    function test_rabbitmq_connection_factory_get_sender()
    {
        $factory = new RabbitMQConnectionFactory();
        $middleware = $factory->getSender();

        $this->assertInstanceOf(AmqpSender::class, $middleware);
    }
    
    function test_rabbitmq_connection_factory_get_reciever()
    {
        $factory = new RabbitMQConnectionFactory();
        $middleware = $factory->getReceiver();

        $this->assertInstanceOf(AmqpReceiver::class, $middleware);
    }

}
