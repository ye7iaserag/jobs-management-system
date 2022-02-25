<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\JobResponse;
use JMS\Job\Domain\Entity\Job;
use Tests\TestCase;
use JMS\Job\Domain\ValueObject\{ JobId, JobDescription, JobOwnerId, JobTitle };

final class JobResponseTest extends TestCase
{
    use WithFaker;

    function test_create_job_response()
    {
        $id = $this->faker->uuid();
        $title = $this->faker->name();
        $description = $this->faker->name();
        $ownerId = $this->faker->uuid();

        $jobResponse = new JobResponse($id, $title, $description, $ownerId);

        $this->assertEquals($id, $jobResponse->id());
        $this->assertEquals($title, $jobResponse->title());
        $this->assertEquals($description, $jobResponse->description());
        $this->assertEquals($ownerId, $jobResponse->ownerId());
    }

    function test_create_job_response_from_job()
    {
        $jobId = new JobId($this->faker->uuid());
        $jobTitle = new JobTitle($this->faker->name());
        $jobDescription = new JobDescription($this->faker->name());
        $jobOwnerId = new JobOwnerId($this->faker->uuid());

        $job = new Job($jobId, $jobTitle, $jobDescription, $jobOwnerId);

        $jobResponse = JobResponse::fromJob($job);

        $this->assertEquals($jobId->value(), $jobResponse->id());
        $this->assertEquals($jobTitle->value(), $jobResponse->title());
        $this->assertEquals($jobDescription->value(), $jobResponse->description());
        $this->assertEquals($jobOwnerId->value(), $jobResponse->ownerId());
    }

    function test_job_response_to_array()
    {
        $id = $this->faker->uuid();
        $title = $this->faker->name();
        $description = $this->faker->name();
        $ownerId = $this->faker->uuid();

        $jobResponse = new JobResponse($id, $title, $description, $ownerId);

        $array = $jobResponse->toArray();

        $this->assertEquals($id, $array['id']);
        $this->assertEquals($title, $array['title']);
        $this->assertEquals($description, $array['description']);
        $this->assertEquals($ownerId, $array['ownerId']);
    }

}