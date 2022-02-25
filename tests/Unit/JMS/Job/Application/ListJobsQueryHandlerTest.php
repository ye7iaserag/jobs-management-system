<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\ListJobs\ListJobsQuery;
use JMS\Job\Application\ListJobs\ListJobsQueryHandler;
use JMS\Job\Domain\Entity\Job;
use JMS\Job\Domain\JobRepository;
use JMS\Job\Domain\Jobs;
use JMS\Job\Domain\JobsFiltration;
use Tests\TestCase;

final class ListJobsQueryHandlerTest extends TestCase
{
    use WithFaker;

    function test_create_get_job_by_id_query_handler()
    {
        $uuid = $this->faker->uuid();
        $this->mock(JobRepository::class, fn ($mock) => $mock->shouldReceive('list')->once()->andReturn(new Jobs([Job::fromPrimitives($uuid, $this->faker->name(), $this->faker->name(), $this->faker->uuid())])));

        $jobRepoMock = $this->app->make(JobRepository::class);

        $command = new ListJobsQuery(new JobsFiltration(null));

        $handler = new ListJobsQueryHandler($jobRepoMock);

        $response = $handler($command);

        $this->assertEquals($response->toArray()[0]['id'], $uuid);
    }

}