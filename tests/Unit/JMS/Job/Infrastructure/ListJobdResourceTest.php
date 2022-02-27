<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use JMS\Job\Application\Response\JobResponse;
use JMS\Job\Application\Response\JobsResponse;
use JMS\Job\Infrastructure\Http\Resources\ListJobsResource;
use Tests\TestCase;

final class ListJobdResourceTest extends TestCase
{
    use WithFaker;

    function test_list_jobs_resource()
    {
        $resource = new ListJobsResource(new JobsResponse([new JobResponse($this->faker->uuid(), $this->faker->name(), $this->faker->name(), $this->faker->uuid())]));

        $array = $resource->toArray($this->app->make(Request::class));

        $this->assertIsArray($array);
        $this->assertArrayHasKey('id', $array[0]);
        $this->assertArrayHasKey('title', $array[0]);
        $this->assertArrayHasKey('description', $array[0]);
        $this->assertArrayHasKey('ownerId', $array[0]);
    }

}
