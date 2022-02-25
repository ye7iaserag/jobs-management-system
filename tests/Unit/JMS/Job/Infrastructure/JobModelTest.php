<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Infrastructure;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JMS\Job\Infrastructure\Persistence\Eloquent\JobModel;

final class JobModelTest extends TestCase
{
    use WithFaker;

    function test_create_job_model()
    {
        $jobModel = new JobModel();
        $jobs = JobModel::newFactory();
        $owner = $jobModel->owner();

        $this->assertNotNull($jobs);
        $this->assertNotNull($owner);

    }

    
    
}
