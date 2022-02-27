<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Exception;

use Shared\Infrastructure\Constant\Error;

class ValidationException extends InfrastructureException
{
    public function __construct(private array $validationErrors)
    {
        parent::__construct(Error::MSG[Error::INVALID_INPUTS], Error::INVALID_INPUTS);
    }

    public function getValidationErrors() {
        return $this->validationErrors;
    }
}
