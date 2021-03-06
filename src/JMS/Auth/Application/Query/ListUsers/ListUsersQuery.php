<?php

declare(strict_types=1);

namespace JMS\Auth\Application\Query\ListUsers;

use Shared\Domain\Bus\Query\Query;
use JMS\Auth\Domain\DTO\UsersFiltration;

final class ListUsersQuery implements Query
{
    public function __construct(private UsersFiltration $filtration)
    {
    }

    public function filtration(): UsersFiltration
    {
        return $this->filtration;
    }
}
