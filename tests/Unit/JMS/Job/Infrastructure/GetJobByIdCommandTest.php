<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\Response\JobResponse;
use Shared\Domain\Bus\Query\QueryBus;
use Tests\TestCase;

final class GetJobByIdCommandTest extends TestCase
{
    use WithFaker;

    function test_get_job_by_id_command()
    {
        $uuid = $this->faker->uuid();
        $ownerId = $this->faker->uuid();
        $this->mock(QueryBus::class, fn ($mock) => $mock->shouldReceive('ask')->once()->andReturn(new JobResponse($uuid, $this->faker->name(), $this->faker->name(), $ownerId)));

        $this->artisan('job:get 1')->assertSuccessful();

    }

}
