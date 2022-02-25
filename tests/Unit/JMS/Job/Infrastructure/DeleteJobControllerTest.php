<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\JobResponse;
use JMS\Job\Infrastructure\Http\Controllers\DeleteJobController;
use JMS\Job\Infrastructure\Http\Requests\DeleteJobRequest;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\Bus\Query\QueryBus;
use Shared\Domain\Entity\Identity;
use Shared\Domain\Enum\Role;
use Shared\Domain\Port\AuthService;
use Shared\Domain\ValueObject\IdentityRole;
use Shared\Domain\ValueObject\UuidValueObject;
use Shared\Infrastructure\Exceptions\AuthorizationException;
use Tests\TestCase;

final class DeleteJobControllerTest extends TestCase
{
    use WithFaker;

    function test_delete_job_controller()
    {
        $uuid = $this->faker->uuid();
        $ownerId = $this->faker->uuid();
        $this->mock(CommandBus::class, fn ($mock) => $mock->shouldReceive('dispatch')->once());
        $this->mock(QueryBus::class, fn ($mock) => $mock->shouldReceive('ask')->once()->andReturn(new JobResponse($uuid, $this->faker->name(), $this->faker->name(), $ownerId)));
        $this->mock(AuthService::class, fn ($mock) => $mock->shouldReceive('getIdentity')->once()->andReturn(new Identity(new UuidValueObject($ownerId), new IdentityRole(Role::Regular))));

        $this->mock(DeleteJobRequest::class, fn ($mock) => $mock->shouldReceive('get')->with('title')->andReturn($this->faker->name())
        ->shouldReceive('get')->with('description')->andReturn($this->faker->name()));

        $commandBus = $this->app->make(CommandBus::class);
        $queryBus = $this->app->make(QueryBus::class);
        $authService = $this->app->make(AuthService::class);

        $request = $this->app->make(DeleteJobRequest::class);

        $controller = new DeleteJobController($commandBus, $queryBus, $authService);

        $controller($request, $uuid);

        //do something with response
    }

    function test_delete_job_controller_unauthorized()
    {
        $uuid = $this->faker->uuid();
        $ownerId = $this->faker->uuid();
        $this->mock(CommandBus::class, fn ($mock) => $mock);
        $this->mock(QueryBus::class, fn ($mock) => $mock->shouldReceive('ask')->once()->andReturn(new JobResponse($uuid, $this->faker->name(), $this->faker->name(), $ownerId)));
        $this->mock(AuthService::class, fn ($mock) => $mock->shouldReceive('getIdentity')->once()->andReturn(new Identity(UuidValueObject::random(), new IdentityRole(Role::Regular))));

        $this->expectException(AuthorizationException::class);

        $commandBus = $this->app->make(CommandBus::class);
        $queryBus = $this->app->make(QueryBus::class);
        $authService = $this->app->make(AuthService::class);

        $request = $this->app->make(DeleteJobRequest::class);

        $controller = new DeleteJobController($commandBus, $queryBus, $authService);

        $controller($request, $uuid);
    }

}
