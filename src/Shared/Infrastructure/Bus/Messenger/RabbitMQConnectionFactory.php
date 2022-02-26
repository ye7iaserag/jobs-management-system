<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Messenger;

use Shared\Domain\Bus\Event\ConnectionFactory;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpReceiver;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpSender;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\Connection;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Middleware\SendMessageMiddleware;

final class RabbitMQConnectionFactory implements ConnectionFactory
{


    public function makeSendMessageMiddleware()
    {
        $sendersLocator = new RabbitMQSenderLocator($this);
        
        $middleware = new SendMessageMiddleware($sendersLocator);
        return $middleware;
    }
    
    public function makeHandleMessageMiddleware(): HandleMessageMiddleware{
        return new HandleMessageMiddleware(
            new HandlersLocator(
                CallableFirstParameterExtractor::forPipedCallables(app()->tagged('domain_event_subscriber'))
            )
        );
    }

    public function getSender() {
        $connection = $this->getRabbitMQConnection();
        return new AmqpSender($connection);
    }

    public function getReceiver() {
        $connection = $this->getRabbitMQConnection();
        return new AmqpReceiver($connection);
    }


    public function getRabbitMQConnection () {
        return new Connection(
            [
                'host' => config('rabbitmq.host'),
                'port' => config('rabbitmq.port'),
                'vhosts' => config('rabbitmq.vhosts'),
                'login' => config('rabbitmq.login'),
                'password' => config('rabbitmq.password')
            ],
            [
                'name' => 'messages'
            ],
            [
                'messages' => []
            ]
        );
    }
}
