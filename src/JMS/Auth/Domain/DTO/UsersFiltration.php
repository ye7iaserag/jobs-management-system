<?php

declare(strict_types=1);

namespace JMS\Auth\Domain\DTO;

use JMS\Auth\Domain\ValueObject\ { UserRole };

final class UsersFiltration
{
    
    public function __construct(
        private ?UserRole $role 
    ) {
    }

    public function role(): ?UserRole
    {
        return $this->role;
    }
}
