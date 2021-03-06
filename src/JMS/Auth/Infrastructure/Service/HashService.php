<?php

declare(strict_types=1);

namespace JMS\Auth\Infrastructure\Service;

use JMS\Auth\Domain\ValueObject\UserPassword;
use JMS\Auth\Domain\Port\HashService as HashServiceInterface;
use Illuminate\Support\Facades\Hash;

final class HashService implements HashServiceInterface
{
    public function check(UserPassword $plainPassword, UserPassword $hash): bool {
        return Hash::check($plainPassword->value(), $hash->value());
    }
}
