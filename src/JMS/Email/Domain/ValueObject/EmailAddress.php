<?php

declare(strict_types=1);

namespace JMS\Email\Domain\ValueObject;

use Shared\Domain\ValueObject\StringValueObject;

final class EmailAddress extends StringValueObject
{
    public function __construct($value)
    {
        if(!filter_var($value, FILTER_VALIDATE_EMAIL)){
            throw new \InvalidArgumentException();
        }
        
        parent::__construct($value);
    }
}
