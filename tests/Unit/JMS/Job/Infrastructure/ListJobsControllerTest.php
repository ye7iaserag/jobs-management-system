<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\JobResponse;
use JMS\Job\Application\JobsResponse;
use JMS\Job\Domain\Entity\Job;
use JMS\Job\Infrastructure\Http\Controllers\DeleteJobController;
use JMS\Job\Infrastructure\Http\Controllers\GetJobByIdController;
use JMS\Job\Infrastructure\Http\Controllers\ListJobsController;
use JMS\Job\Infrastructure\Http\Requests\DeleteJobRequest;
use JMS\Job\Infrastructure\Http\Requests\GetJobByIdRequest;
use JMS\Job\Infrastructure\Http\Requests\ListJobsRequest;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\Bus\Query\QueryBus;
use Shared\Domain\Entity\Identity;
use Shared\Domain\Enum\Role;
use Shared\Domain\Port\AuthService;
use Shared\Domain\ValueObject\IdentityRole;
use Shared\Domain\ValueObject\UuidValueObject;
use Shared\Infrastructure\Exceptions\AuthorizationException;
use Tests\TestCase;

final class ListJobsControllerTest  extends TestCase
{
    use WithFaker;

    function test_list_jobs_controller_for_regular()
    {
        $this->mock(QueryBus::class, fn ($mock) => $mock->shouldReceive('ask')->once()->andReturn(new JobsResponse([new JobResponse($this->faker->uuid(), $this->faker->name(), $this->faker->name(), $this->faker->uuid())])));
        $this->mock(AuthService::class, fn ($mock) => $mock->shouldReceive('getIdentity')->once()->andReturn(new Identity(UuidValueObject::random(), new IdentityRole(Role::Regular))));

        $queryBus = $this->app->make(QueryBus::class);
        $authService = $this->app->make(AuthService::class);

        $request = $this->app->make(ListJobsRequest::class);

        $controller = new ListJobsController($queryBus, $authService);

        $controller($request);

        //do something with response
    }

    function test_list_jobs_controller_for_manager()
    {
        $this->mock(QueryBus::class, fn ($mock) => $mock->shouldReceive('ask')->once()->andReturn(new JobsResponse([new JobResponse($this->faker->uuid(), $this->faker->name(), $this->faker->name(), $this->faker->uuid())])));
        $this->mock(AuthService::class, fn ($mock) => $mock->shouldReceive('getIdentity')->once()->andReturn(new Identity(UuidValueObject::random(), new IdentityRole(Role::Manager))));

        $queryBus = $this->app->make(QueryBus::class);
        $authService = $this->app->make(AuthService::class);

        $request = $this->app->make(ListJobsRequest::class);

        $controller = new ListJobsController($queryBus, $authService);

        $controller($request);

        //do something with response
    }

}
