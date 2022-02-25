<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\GetJob\GetJobByIdQuery;
use JMS\Job\Application\GetJob\GetJobByIdQueryHandler;
use JMS\Job\Domain\Entity\Job;
use JMS\Job\Domain\Exceptions\JobNotFound;
use JMS\Job\Domain\JobRepository;
use Tests\TestCase;

final class GetJobByIdQueryHandlerTest extends TestCase
{
    use WithFaker;

    function test_create_get_job_by_id_query_handler()
    {
        $uuid = $this->faker->uuid();
        $this->mock(JobRepository::class, fn ($mock) => $mock->shouldReceive('find')->once()->andReturn(Job::fromPrimitives($uuid, $this->faker->name(), $this->faker->name(), $this->faker->uuid())));

        $jobRepoMock = $this->app->make(JobRepository::class);

        $command = new GetJobByIdQuery($uuid);

        $handler = new GetJobByIdQueryHandler($jobRepoMock);

        $response = $handler($command);

        $this->assertEquals($response->toArray()['id'], $uuid);
    }

    function test_get_job_by_id_query_handler_existing_job()
    {
        $this->mock(JobRepository::class, fn ($mock) => $mock->shouldReceive('find')->once()->andReturn(null)->shouldReceive('delete'));

        $this->expectException(JobNotFound::class);

        $jobRepoMock = $this->app->make(JobRepository::class);

        $command = new GetJobByIdQuery($this->faker->uuid());

        $handler = new GetJobByIdQueryHandler($jobRepoMock);

        $handler($command);
    }

}