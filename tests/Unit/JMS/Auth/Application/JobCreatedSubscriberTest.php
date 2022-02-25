<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Auth\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Application\Subscriber\JobCreatedSubscriber;
use JMS\Auth\Application\UserResponse;
use JMS\Auth\Application\UsersResponse;
use JMS\Job\Domain\Event\JobCreated;
use Shared\Domain\Bus\Event\EventBus;
use Shared\Domain\Bus\Query\QueryBus;
use Tests\TestCase;

final class JobCreatedSubscriberTest extends TestCase
{
    use WithFaker;

    function test_create_job_created_subscriber()
    {
        $uuid = $this->faker->uuid();

        $this->mock(QueryBus::class, fn ($mock) => $mock->shouldReceive('ask')->once()->andReturn(new UsersResponse([new UserResponse($this->faker->uuid(), $this->faker->email())])));
        $this->mock(EventBus::class, fn ($mock) => $mock->shouldReceive('publish')->once());

        $queryBus = $this->app->make(QueryBus::class);
        $eventBus = $this->app->make(EventBus::class);

        $event = new JobCreated($uuid);

        $subscriber = new JobCreatedSubscriber($queryBus, $eventBus);

        $subscriber($event);
    }

    function test_create_job_created_subscriber_no_users()
    {
        $uuid = $this->faker->uuid();

        $this->mock(QueryBus::class, fn ($mock) => $mock->shouldReceive('ask')->once()->andReturn(new UsersResponse([])));

        $queryBus = $this->app->make(QueryBus::class);
        $eventBus = $this->app->make(EventBus::class);

        $event = new JobCreated($uuid);

        $subscriber = new JobCreatedSubscriber($queryBus, $eventBus);

        $subscriber($event);
    }

    function test_job_created_subscriber_is_subscribed() {
        $array = JobCreatedSubscriber::subscribedTo();

        $this->assertIsArray($array);
        $this->assertTrue(count($array) >= 1);
    }

}