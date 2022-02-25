<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JMS\Job\Domain\Event\JobDeleted;

final class JobDeletedTest extends TestCase
{
    use WithFaker;

    function test_create_job_deleted()
    {
        $uuid = $this->faker->uuid();
        $payload = [];
        $eventUuid = $this->faker->uuid();
        $occuredOn = $this->faker->name();

        $jobDeleted = JobDeleted::fromPrimitives($uuid, $payload, $eventUuid, $occuredOn);

        $this->assertEquals($uuid, $jobDeleted->aggregateId());
        $this->assertEquals($payload, $jobDeleted->payload());
        $this->assertEquals($eventUuid, $jobDeleted->eventId());
        $this->assertEquals($occuredOn, $jobDeleted->occurredOn());
    }

    function test_job_deleted_to_primitives()
    {
        $uuid = $this->faker->uuid();
        $payload = [];
        $eventUuid = $this->faker->uuid();
        $occuredOn = $this->faker->name();

        $jobDeleted = JobDeleted::fromPrimitives($uuid, $payload, $eventUuid, $occuredOn);

        $primitives = $jobDeleted->toPrimitives();
        $this->assertEquals($uuid, $primitives[0]);
        $this->assertEquals($payload, $primitives[1]);
        $this->assertEquals($eventUuid, $primitives[2]);
        $this->assertEquals($occuredOn, $primitives[3]);
    }

    function test_job_deleted_name() {
        $jobDeleted = new JobDeleted($this->faker->uuid(), [], $this->faker->uuid(), );
        $this->assertEquals(JobDeleted::EVENT_NAME, $jobDeleted->eventName($this->faker->name()));
    }

    
    
}
