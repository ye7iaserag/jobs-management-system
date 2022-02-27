<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\ListJobs\ListJobsQuery;
use JMS\Job\Domain\DTO\JobsFiltration;
use JMS\Job\Domain\ValueObject\JobOwnerId;
use Tests\TestCase;

final class ListJobsQueryTest extends TestCase
{
    use WithFaker;

    function test_create_get_job_by_id_command()
    {
        $id = $this->faker->uuid();

        $query = new ListJobsQuery(new JobsFiltration(new JobOwnerId($id)));

        $this->assertEquals($id, $query->filtration()->ownerId()->value());
    }

}