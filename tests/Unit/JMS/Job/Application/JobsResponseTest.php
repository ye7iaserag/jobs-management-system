<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\JobResponse;
use JMS\Job\Application\JobsResponse;
use JMS\Job\Domain\Entity\Job;
use Tests\TestCase;
use JMS\Job\Domain\ValueObject\{ JobId, JobDescription, JobOwnerId, JobTitle };
use JMS\Job\Domain\Jobs;

final class JobsResponseTest extends TestCase
{
    use WithFaker;

    function test_create_jobs_response()
    {
        $id = $this->faker->uuid();
        $title = $this->faker->name();
        $description = $this->faker->name();
        $ownerId = $this->faker->uuid();

        $jobResponseArr = [];

        $jobResponseArr[] = new JobResponse($id, $title, $description, $ownerId);
        $jobResponseArr[] = new JobResponse($id, $title, $description, $ownerId);

        $jobsResponse = new JobsResponse($jobResponseArr);

        $this->assertEquals(count($jobResponseArr), count($jobsResponse->toArray()));
    }

    function test_create_jobs_response_from_job()
    {
        $jobId = new JobId($this->faker->uuid());
        $jobTitle = new JobTitle($this->faker->name());
        $jobDescription = new JobDescription($this->faker->name());
        $jobOwnerId = new JobOwnerId($this->faker->uuid());

        $jobArr = [];
        $jobArr[] = new Job($jobId, $jobTitle, $jobDescription, $jobOwnerId);
        $jobArr[] = new Job($jobId, $jobTitle, $jobDescription, $jobOwnerId);

        $jobsResponse = JobsResponse::fromJobs(new Jobs($jobArr));

        $this->assertEquals(count($jobArr), count($jobsResponse->toArray()));
    }

}