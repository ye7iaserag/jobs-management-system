<?php

declare(strict_types=1);

namespace JMS\Job\Domain\Exceptions;

use Shared\Domain\Port\DomainException;
use Throwable;

final class JobAlreadyExists extends DomainException
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = "" === $message ? "Job already exists" : $message;

        parent::__construct($message, $code, $previous);
    }
}
