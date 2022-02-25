<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Domain\Entity\User;
use JMS\Auth\Infrastructure\JwtRepository;
use Shared\Domain\Enum\Role;
use Tests\TestCase;

final class JwtRepositoryTest extends TestCase
{
    use WithFaker;

    function test_hash_check()
    {
        $jwtRepo = new JwtRepository();

        $user = User::fromPrimitives($this->faker->uuid(), $this->faker->email(), $this->faker->name(), Role::Regular->value);

        $token = $jwtRepo->getToken($user);

        $this->assertNotNull($token);
    }

}
