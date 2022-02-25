<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JMS\Job\Domain\Entity\Job;
use JMS\Job\Domain\Entity\JobOwner;
use JMS\Job\Domain\Event\JobCreated;
use JMS\Job\Domain\Event\JobDeleted;
use JMS\Job\Domain\Event\JobUpdated;
use JMS\Job\Domain\ValueObject\{ JobId, JobDescription, JobOwnerId, JobOwnerName, JobTitle };

final class JobTest extends TestCase
{
    use WithFaker;

    function test_create_job()
    {
        $jobId = new JobId($this->faker->uuid());
        $jobTitle = new JobTitle($this->faker->name());
        $jobDescription = new JobDescription($this->faker->name());
        $jobOwnerId = new JobOwnerId($this->faker->uuid());
        $jobOwnerName = new JobOwnerName($this->faker->name());

        $jobOwner = new JobOwner($jobOwnerId,$jobOwnerName);
        
        $job = new Job($jobId, $jobTitle, $jobDescription, $jobOwnerId, $jobOwner);

        $this->assertEquals($jobId->value(), $job->id()->value());
        $this->assertEquals($jobTitle->value(), $job->title()->value());
        $this->assertEquals($jobDescription->value(), $job->description()->value());
        $this->assertEquals($jobOwnerId->value(), $job->ownerId()->value());
        $this->assertEquals($jobOwnerId->value(), $job->owner()->id()->value());
        $this->assertEquals($job->ownerId(), $job->owner()->id()->value());
    }

    function test_hydrate_job()
    {
        $id = $this->faker->uuid();
        $title = $this->faker->name();
        $description = $this->faker->name();
        $ownerId = $this->faker->uuid();

        $job = Job::fromPrimitives($id, $title, $description, $ownerId);

        $this->assertEquals($id, $job->id()->value());
        $this->assertEquals($title, $job->title()->value());
        $this->assertEquals($description, $job->description()->value());
        $this->assertEquals($ownerId, $job->ownerId()->value());
    }

    function test_modify_job()
    {
        $jobId = new JobId($this->faker->uuid());
        $jobTitle = new JobTitle($this->faker->name());
        $jobDescription = new JobDescription($this->faker->name());
        $jobOwnerId = new JobOwnerId($this->faker->uuid());
        
        $job = new Job($jobId, $jobTitle, $jobDescription, $jobOwnerId);

        $newJobTitle = new JobTitle($this->faker->name());
        $newJobDescription = new JobDescription($this->faker->name());

        $job->modify($newJobTitle, $newJobDescription);

        $this->assertEquals($newJobTitle->value(), $job->title()->value());
        $this->assertEquals($newJobDescription->value(), $job->description()->value());
    }
    
    function test_job_fires_domain_events()
    {
        $jobId = new JobId($this->faker->uuid());
        $jobTitle = new JobTitle($this->faker->name());
        $jobDescription = new JobDescription($this->faker->name());
        $jobOwnerId = new JobOwnerId($this->faker->uuid());

        $job = Job::make($jobId, $jobTitle, $jobDescription, $jobOwnerId);
        $this->assertEquals(JobCreated::class, get_class($job->pullDomainEvents()[0]));
        
        $job->modify(new JobTitle($this->faker->name()), new JobDescription($this->faker->name()));
        $this->assertEquals(JobUpdated::class, get_class($job->pullDomainEvents()[0]));

        $job->delete();
        $this->assertEquals(JobDeleted::class, get_class($job->pullDomainEvents()[0]));
    }
    
}
