<?php

declare(strict_types=1);

namespace Shared\Domain\Entity;

use Shared\Domain\ValueObject\IdentityRole;
use Shared\Domain\ValueObject\UuidValueObject;

final class Identity
{
    public function __construct(private UuidValueObject $id, private IdentityRole $role)
    {
    }

    public static function fromPrimitives(string $id, int $role): self
    {
        return new self(
            UuidValueObject::fromValue($id),
            IdentityRole::fromValue($role),
        );
    }

    public function id() {
        return $this->id;
    }

    public function role() {
        return $this->role;
    }
}
