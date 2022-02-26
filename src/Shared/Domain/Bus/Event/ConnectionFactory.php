<?php

declare(strict_types=1);

namespace Shared\Domain\Bus\Event;

interface ConnectionFactory
{
    public function makeSendMessageMiddleware();
    
    public function makeHandleMessageMiddleware();

    public function getSender();

    public function getReceiver();

}
