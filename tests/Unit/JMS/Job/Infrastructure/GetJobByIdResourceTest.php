<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use JMS\Job\Application\Response\JobResponse;
use JMS\Job\Infrastructure\Http\Resources\GetJobByIdResource;
use Tests\TestCase;

final class GetJobByIdResourceTest extends TestCase
{
    use WithFaker;

    function test_get_job_by_id_resource()
    {
        $resource = new GetJobByIdResource(new JobResponse($this->faker->uuid(), $this->faker->name(), $this->faker->name(), $this->faker->uuid()));

        $array = $resource->toArray($this->app->make(Request::class));

        $this->assertIsArray($array);
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('title', $array);
        $this->assertArrayHasKey('description', $array);
        $this->assertArrayHasKey('ownerId', $array);
    }

}
