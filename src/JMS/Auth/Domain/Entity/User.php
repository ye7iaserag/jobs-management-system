<?php

declare(strict_types=1);

namespace JMS\Auth\Domain\Entity;

use Shared\Domain\Aggregate\AggregateRoot;
use JMS\Auth\Domain\ValueObject\ { UserId, UserEmail, UserPassword, UserRole };

final class User extends AggregateRoot
{
    public function __construct(
        private UserId $id,
        private UserEmail $email,
        private UserPassword $password,
        private UserRole $role
    ) {
    }

    public static function fromPrimitives(string $id, string $email, string $password, int $role): self
    {
        return new self(
            UserId::fromValue($id),
            UserEmail::fromValue($email),
            UserPassword::fromValue($password),
            UserRole::fromValue($role),
        );
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function password(): UserPassword
    {
        return $this->password;
    }

    public function role(): UserRole
    {
        return $this->role;
    }
}
