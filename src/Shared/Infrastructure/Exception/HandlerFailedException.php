<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Exception;

use Shared\Infrastructure\Constant\Error;
use Shared\Infrastructure\Exception\InfrastructureException;

class HandlerFailedException extends InfrastructureException
{
    public function __construct()
    {
        parent::__construct(Error::MSG[Error::HANDLER_FAILED], Error::HANDLER_FAILED);
    }
}
