<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\JobResponse;
use JMS\Job\Application\JobsResponse;
use Shared\Domain\Bus\Query\QueryBus;
use Tests\TestCase;

final class ListJobsCommandTest extends TestCase
{
    use WithFaker;

    function test_list_jobs_command()
    {
        $uuid = $this->faker->uuid();
        $ownerId = $this->faker->uuid();
        $this->mock(QueryBus::class, fn ($mock) => $mock->shouldReceive('ask')->once()->andReturn(new JobsResponse([new JobResponse($uuid, $this->faker->name(), $this->faker->name(), $ownerId)])));

        $this->artisan('job:list')->assertSuccessful();
    }

}
