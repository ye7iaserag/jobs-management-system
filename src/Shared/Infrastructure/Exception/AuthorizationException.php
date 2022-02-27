<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Exception;

use Shared\Infrastructure\Constant\Error;
use Shared\Infrastructure\Exception\InfrastructureException;

class AuthorizationException extends InfrastructureException
{
    public function __construct(?int $code = null)
    {
        $code = !is_null($code)? $code : Error::UNAUTHORIZED_ACCESS;
        parent::__construct(Error::MSG[$code], $code);
    }
}
