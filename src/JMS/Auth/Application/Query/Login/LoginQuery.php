<?php

declare(strict_types=1);

namespace JMS\Auth\Application\Query\Login;

use Shared\Domain\Bus\Query\Query;

final class LoginQuery implements Query
{
    public function __construct(private string $email, private string $password)
    {
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }
}
