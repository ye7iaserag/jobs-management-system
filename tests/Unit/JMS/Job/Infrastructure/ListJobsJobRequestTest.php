<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Infrastructure\Http\Requests\ListJobsRequest;
use Tests\TestCase;

final class ListJobsJobRequestTest extends TestCase
{
    use WithFaker;

    function test_create_list_jobs_request()
    {
        $request = new ListJobsRequest();

        $isAuthoized = $request->authorize();
        $rules = $request->rules();

        $this->assertIsBool($isAuthoized);
        $this->assertIsArray($rules);
    }

}
