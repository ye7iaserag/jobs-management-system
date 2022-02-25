<?php

declare(strict_types=1);

namespace JMS\Auth\Application;

use JMS\Auth\Domain\Entity\User;
use Shared\Domain\Bus\Query\Response;

final class UserResponse implements Response
{


    public function __construct(private string $id, private string $email)
    {}

    public static function fromUser(User $user): self
    {
        return new self(
            $user->id()->value(),
            $user->email()->value(),
        );
    }

    public function id(): string
    {
        return $this->id;
    }

    public function email(): string
    {
        return $this->email;
    }


    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email
        ];
    }
}
