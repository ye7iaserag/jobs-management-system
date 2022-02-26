<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Messenger;

use Shared\Domain\Bus\Event\ConnectionFactory;
use Shared\Domain\Bus\Event\DomainEvent;
use Shared\Domain\Bus\Event\EventBus;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;

final class MessengerEventBus implements EventBus
{
    private MessageBus $bus;

    public function __construct(private iterable $subscribers, private ConnectionFactory $middlewareFactory)
    {
    }

    public function publish(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            try {
                $this->getBus()->dispatch(new Envelope($event));
            } catch (NoHandlerForMessageException) {
            }
        }
    }

    private function getBus()
    {
        if (isset($this->bus)) return $this->bus;

        $this->bus = new MessageBus(
            [
                $this->middlewareFactory->makeSendMessageMiddleware()
            ]
        );

        return $this->bus;
    }
}
