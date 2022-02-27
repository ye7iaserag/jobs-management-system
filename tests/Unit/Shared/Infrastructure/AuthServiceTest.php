<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Shared\Domain\Enum\Role;
use Shared\Infrastructure\Persistence\Eloquent\UserModel;
use Shared\Infrastructure\Service\AuthService;

final class AuthServiceTest extends TestCase
{
    use WithFaker;

    function test_auth_service_get_identity()
    {
        $id = $this->faker->uuid();
        $role = Role::Regular->value;

        $user = new UserModel();
        $user->id = $id;
        $user->role = Role::Regular->value;

        Auth::shouldReceive('user')->twice()->andreturn($user);

        $authService = new AuthService();
        $identity = $authService->getIdentity();

        $this->assertEquals($id, $identity->id()->value());
        $this->assertEquals($role, $identity->role()->value()->value);
    }
    
}
