<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Infrastructure\Http\Requests\UpdateJobRequest;
use Tests\TestCase;

final class UpdateJobRequestTest extends TestCase
{
    use WithFaker;

    function test_create_create_job_request()
    {
        $request = new UpdateJobRequest();

        $isAuthoized = $request->authorize();
        $rules = $request->rules();

        $this->assertIsBool($isAuthoized);
        $this->assertIsArray($rules);
    }

}
