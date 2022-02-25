<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Infrastructure\Http\Requests\DeleteJobRequest;
use Tests\TestCase;

final class DeleteJobRequestTest extends TestCase
{
    use WithFaker;

    function test_create_delete_job_request()
    {
        
        $request = new DeleteJobRequest();

        $isAuthoized = $request->authorize();
        $rules = $request->rules();

        $this->assertIsBool($isAuthoized);
        $this->assertIsArray($rules);
    }

}
