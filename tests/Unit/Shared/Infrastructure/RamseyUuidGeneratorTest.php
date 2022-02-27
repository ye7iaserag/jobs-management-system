<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Shared\Domain\Enum\Role;
use Shared\Infrastructure\Persistence\Eloquent\UserModel;
use Shared\Infrastructure\Service\AuthService;
use Shared\Infrastructure\Service\RamseyUuidGenerator;

final class RamseyUuidGeneratorTest extends TestCase
{
    use WithFaker;

    function test_ramsey_uuid_generator()
    {
        $generator = new RamseyUuidGenerator();
        $uuid = $generator->generate();

        $this->assertMatchesRegularExpression('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $uuid);
    }
    
}
