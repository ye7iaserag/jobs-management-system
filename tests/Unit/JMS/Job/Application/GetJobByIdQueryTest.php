<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\Query\GetJob\GetJobByIdQuery;
use Tests\TestCase;

final class GetJobByIdQueryTest extends TestCase
{
    use WithFaker;

    function test_create_get_job_by_id_command()
    {
        $id = $this->faker->uuid();

        $query = new GetJobByIdQuery($id);

        $this->assertEquals($id, $query->id());
    }

}