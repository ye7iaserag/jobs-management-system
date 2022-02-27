<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Exception;

use Shared\Infrastructure\Constant\Error;

class UnknownErrorException extends InfrastructureException
{
    public function __construct()
    {
        parent::__construct(Error::MSG[Error::UNKNOWN_ERROR], Error::UNKNOWN_ERROR);
    }
}
