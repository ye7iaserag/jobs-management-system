<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use JMS\Job\Infrastructure\Http\Resources\DeleteJobResource;
use JMS\Job\Infrastructure\Http\Resources\UpdateJobResource;
use Tests\TestCase;

final class DeleteJobResourceTest extends TestCase
{
    use WithFaker;

    function test_delete_job_resource()
    {
        $resource = new DeleteJobResource([true]);

        $array = $resource->toArray($this->app->make(Request::class));

        $this->assertIsArray($array);
        $this->assertIsBool($array[0]);
    }

}
