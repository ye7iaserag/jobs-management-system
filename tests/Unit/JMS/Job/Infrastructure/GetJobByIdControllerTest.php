<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\JobResponse;
use JMS\Job\Infrastructure\Http\Controllers\DeleteJobController;
use JMS\Job\Infrastructure\Http\Controllers\GetJobByIdController;
use JMS\Job\Infrastructure\Http\Requests\DeleteJobRequest;
use JMS\Job\Infrastructure\Http\Requests\GetJobByIdRequest;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\Bus\Query\QueryBus;
use Shared\Domain\Entity\Identity;
use Shared\Domain\Enum\Role;
use Shared\Domain\Port\AuthService;
use Shared\Domain\ValueObject\IdentityRole;
use Shared\Domain\ValueObject\UuidValueObject;
use Shared\Infrastructure\Exceptions\AuthorizationException;
use Tests\TestCase;

final class GetJobByIdControllerTest extends TestCase
{
    use WithFaker;

    function test_get_job_by_id_controller()
    {
        $uuid = $this->faker->uuid();
        $ownerId = $this->faker->uuid();
        $this->mock(QueryBus::class, fn ($mock) => $mock->shouldReceive('ask')->once()->andReturn(new JobResponse($uuid, $this->faker->name(), $this->faker->name(), $ownerId)));
        $this->mock(AuthService::class, fn ($mock) => $mock->shouldReceive('getIdentity')->once()->andReturn(new Identity(new UuidValueObject($ownerId), new IdentityRole(Role::Regular))));

        $queryBus = $this->app->make(QueryBus::class);
        $authService = $this->app->make(AuthService::class);

        $request = $this->app->make(GetJobByIdRequest::class);

        $controller = new GetJobByIdController($queryBus, $authService);

        $controller($request, $uuid);

        //do something with response
    }

    function test_get_job_by_id_controller_unauthorized()
    {
        $uuid = $this->faker->uuid();
        $ownerId = $this->faker->uuid();
        $this->mock(QueryBus::class, fn ($mock) => $mock->shouldReceive('ask')->once()->andReturn(new JobResponse($uuid, $this->faker->name(), $this->faker->name(), $ownerId)));
        $this->mock(AuthService::class, fn ($mock) => $mock->shouldReceive('getIdentity')->once()->andReturn(new Identity(UuidValueObject::random(), new IdentityRole(Role::Regular))));

        $this->expectException(AuthorizationException::class);

        $queryBus = $this->app->make(QueryBus::class);
        $authService = $this->app->make(AuthService::class);

        $request = $this->app->make(GetJobByIdRequest::class);

        $controller = new GetJobByIdController($queryBus, $authService);

        $controller($request, $uuid);
    }

}
