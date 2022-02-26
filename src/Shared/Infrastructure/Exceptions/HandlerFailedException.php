<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Exceptions;

use Shared\Infrastructure\Constants\Error;
use Shared\Infrastructure\Exceptions\InfrastructureException;

class HandlerFailedException extends InfrastructureException
{
    public function __construct()
    {
        parent::__construct(Error::MSG[Error::HANDLER_FAILED], Error::HANDLER_FAILED);
    }
}
