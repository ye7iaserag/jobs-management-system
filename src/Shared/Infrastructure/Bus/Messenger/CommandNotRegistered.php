<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Bus\Messenger;

use Shared\Infrastructure\Exceptions\InfrastructureException;
use Throwable;

final class CommandNotRegistered extends InfrastructureException
{
    public function __construct($message = "", $code = null, Throwable $previous = null)
    {
        $message = "" === $message ? "Command not registered" : $message;
        parent::__construct($message, $code, $previous);
    }
}
