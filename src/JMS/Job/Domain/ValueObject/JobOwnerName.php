<?php

declare(strict_types=1);

namespace JMS\Job\Domain\ValueObject;

use Shared\Domain\ValueObject\StringValueObject;

final class JobOwnerName extends StringValueObject
{
    public function __construct(string $value)
    {
        $stringLength = strlen($value);
        if($stringLength === 0 || $stringLength > 100){
            throw new \InvalidArgumentException();
        }
        
        parent::__construct($value);
    }

}
