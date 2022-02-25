<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Shared\Domain\Entity\Identity;
use Shared\Domain\Enum\Role;
use Shared\Domain\ValueObject\IdentityRole;
use Shared\Domain\ValueObject\UuidValueObject;

final class IdentityTest extends TestCase
{
    use WithFaker;

    function test_create_identity()
    {
        $id = new UuidValueObject($this->faker->uuid());
        $role = new IdentityRole(Role::Regular);

        $identity = new Identity($id, $role);

        $this->assertEquals($id->value(), $identity->id()->value());
        $this->assertEquals($role->value()->value, $identity->role()->value()->value);
    }

    function test_hydrate_identity()
    {
        $id = $this->faker->uuid();
        $role = Role::Regular;

        $identity = Identity::fromPrimitives($id, $role->value);

        $this->assertEquals($id, $identity->id()->value());
        $this->assertEquals($role, $identity->role()->value());
    }
    
}
