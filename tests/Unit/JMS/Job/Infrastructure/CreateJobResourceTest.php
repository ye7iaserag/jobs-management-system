<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use JMS\Job\Infrastructure\Http\Resources\CreateJobResource;
use Tests\TestCase;

final class CreateJobResourceTest extends TestCase
{
    use WithFaker;

    function test_create_job_resource()
    {
        $resource = new CreateJobResource(['id' => $this->faker->uuid()]);

        $array = $resource->toArray($this->app->make(Request::class));

        $this->assertIsArray($array);
        $this->assertArrayHasKey('id', $array);
    }

}
