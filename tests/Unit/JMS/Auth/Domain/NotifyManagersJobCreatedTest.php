<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Domain;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Domain\Event\NotifyManagersJobCreated;
use Tests\TestCase;

final class NotifyManagersJobCreatedTest extends TestCase
{
    use WithFaker;

    function test_create_notify_managers_job_created()
    {
        $uuid = $this->faker->uuid();
        $payload = [];
        $eventUuid = $this->faker->uuid();
        $occuredOn = $this->faker->name();

        $event = NotifyManagersJobCreated::fromPrimitives($uuid, $payload, $eventUuid, $occuredOn);

        $this->assertEquals($uuid, $event->aggregateId());
        $this->assertEquals($payload, $event->payload());
        $this->assertEquals($eventUuid, $event->eventId());
        $this->assertEquals($occuredOn, $event->occurredOn());
    }

    function test_notify_managers_job_created_to_primitives()
    {
        $uuid = $this->faker->uuid();
        $payload = [];
        $eventUuid = $this->faker->uuid();
        $occuredOn = $this->faker->name();

        $event = NotifyManagersJobCreated::fromPrimitives($uuid, $payload, $eventUuid, $occuredOn);

        $primitives = $event->toPrimitives();
        $this->assertEquals($uuid, $primitives[0]);
        $this->assertEquals($payload, $primitives[1]);
        $this->assertEquals($eventUuid, $primitives[2]);
        $this->assertEquals($occuredOn, $primitives[3]);
    }

    function test_notify_managers_job_created_name() {
        $event = new NotifyManagersJobCreated($this->faker->uuid(), [], $this->faker->uuid(), );
        $this->assertEquals(NotifyManagersJobCreated::EVENT_NAME, $event->eventName($this->faker->name()));
    }

    
    
}
