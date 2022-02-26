<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Exceptions;

use Exception;
use Shared\Infrastructure\Constants\Error;

abstract class InfrastructureException extends Exception
{
    public function __construct(string $message = "", ?int $code = null, $previous = null)
    {
        $code = is_null($code) || !array_key_exists($code, Error::MSG)? Error::UNKNOWN_ERROR : $code;
        
        parent::__construct(Error::MSG[$code], $code, $previous);
    }
}
