<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JMS\Job\Domain\Entity\JobOwner;
use JMS\Job\Domain\ValueObject\{ JobOwnerId, JobOwnerName };

final class JobOwnerTest extends TestCase
{
    use WithFaker;

    function test_create_job_owner()
    {
        $jobOwnerId = new JobOwnerId($this->faker->uuid());
        $jobOwnerName = new JobOwnerName($this->faker->name());

        $jobOwner = new JobOwner($jobOwnerId,$jobOwnerName);

        $this->assertEquals($jobOwnerId->value(), $jobOwner->id()->value());
        $this->assertEquals($jobOwnerName->value(), $jobOwner->name()->value());
    }

    function test_hydrate_job_owner()
    {
        $id = $this->faker->uuid();
        $name = $this->faker->name();

        $jobOwner = JobOwner::fromPrimitives($id, $name);

        $this->assertEquals($id, $jobOwner->id()->value());
        $this->assertEquals($name, $jobOwner->name()->value());
    }
    
}
