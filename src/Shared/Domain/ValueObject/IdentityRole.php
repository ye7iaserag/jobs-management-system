<?php

declare(strict_types=1);

namespace Shared\Domain\ValueObject;

use Shared\Domain\Enum\Role;
use Shared\Domain\ValueObject\UuidValueObject;

class IdentityRole
{

    public function __construct(private Role $value)
    {}
    
    public static function fromValue(int $value) : self
    {
        return new static(Role::from($value));
    }

    public function value(): Role
    {
        return $this->value;
    }

}
