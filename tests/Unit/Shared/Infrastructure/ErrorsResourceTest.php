<?php

declare(strict_types=1);

namespace Tests\Unit\Shared\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Shared\Infrastructure\Http\Resources\ErrorsResource;
use Tests\TestCase;

final class ErrorsResourceTest extends TestCase
{
    use WithFaker;

    function test_create_errors_resource()
    {
        $resource = new ErrorsResource(['id' => $this->faker->uuid()]);

        $array = $resource->toArray($this->app->make(Request::class));

        $this->assertIsArray($array);
        $this->assertArrayHasKey('id', $array);
    }

}
