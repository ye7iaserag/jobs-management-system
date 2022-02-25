<?php

declare(strict_types=1);

namespace JMS\Auth\Domain\ValueObject;

use Shared\Domain\ValueObject\StringValueObject;

final class UserEmail extends StringValueObject
{
    public function __construct(string $value)
    {
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
            throw new \InvalidArgumentException();
        }
        
        parent::__construct($value);
    }

}
