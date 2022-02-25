<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Messenger;

use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\Bus\Event\EventBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\MessageBus;

final class MessengerEventBus implements EventBus
{
    private MessageBus $bus;

    public function __construct(iterable $subscribers, RabbitMQConnectionFactory $middlewareFactory)
    {

        $middleware = $middlewareFactory->makeSendMessageMiddleware();

        $this->bus = new MessageBus(
            [
                $middleware
            ]
        );
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->bus->dispatch(new Envelope($event));
            } catch (NoHandlerForMessageException) {
            }
        }
    }
}
