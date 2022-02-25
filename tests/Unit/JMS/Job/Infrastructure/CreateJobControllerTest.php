<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Infrastructure\Http\Controllers\CreateJobController;
use JMS\Job\Infrastructure\Http\Requests\CreateJobRequest;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\Entity\Identity;
use Shared\Domain\Enum\Role;
use Shared\Domain\Port\AuthService;
use Shared\Domain\Port\UuidGenerator;
use Shared\Domain\ValueObject\IdentityRole;
use Shared\Domain\ValueObject\UuidValueObject;
use Tests\TestCase;

final class CreateJobControllerTest extends TestCase
{
    use WithFaker;

    function test_create_job_controller()
    {
        $this->mock(CommandBus::class, fn ($mock) => $mock->shouldReceive('dispatch')->once());
        $this->mock(UuidGenerator::class, fn ($mock) => $mock->shouldReceive('generate')->once()->andReturn($this->faker->uuid()));
        $this->mock(AuthService::class, fn ($mock) => $mock->shouldReceive('getIdentity')->once()->andReturn(new Identity(UuidValueObject::random(), new IdentityRole(Role::Regular))));

        $this->mock(CreateJobRequest::class, fn ($mock) => $mock->shouldReceive('get')->with('title')->andReturn($this->faker->name())
        ->shouldReceive('get')->with('description')->andReturn($this->faker->name()));

        $commandBus = $this->app->make(CommandBus::class);
        $uuidGenerator = $this->app->make(UuidGenerator::class);
        $authService = $this->app->make(AuthService::class);

        $request = $this->app->make(CreateJobRequest::class);

        $controller = new CreateJobController($commandBus, $uuidGenerator, $authService);

        $controller($request);
    }

}
