<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Messenger;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\Sender\SendersLocatorInterface;

class RabbitMQSenderLocator implements SendersLocatorInterface
{

    public function __construct(private RabbitMQConnectionFactory $factory)
    {
    }

    public function getSenders(Envelope $envelope): iterable
    {
        return [
            'async' => $this->factory->getSender()
        ];
    }
}
