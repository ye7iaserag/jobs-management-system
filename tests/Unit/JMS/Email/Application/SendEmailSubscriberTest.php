<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Email\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Auth\Domain\Event\NotifyManagersJobCreated;
use JMS\Email\Application\Send\SendEmailCommand;
use JMS\Email\Application\Send\SendEmailCommandHandler;
use JMS\Email\Application\Service\SendEmailService;
use JMS\Email\Application\Subscriber\SendEmailSubscriber;
use Tests\TestCase;

final class SendEmailSubscriberTest extends TestCase
{
    use WithFaker;

    function test_create_send_email_subscriber()
    {
        $this->mock(SendEmailService::class, fn ($mock) => $mock->shouldReceive('send')->once());

        $service = $this->app->make(SendEmailService::class);

        $event = new NotifyManagersJobCreated($this->faker->uuid(), [$this->faker->email()]);
        $subscriber = new SendEmailSubscriber($service);

        $subscriber($event);
    }

    function test_send_email_subscriber_is_subscribed() {
        $array = SendEmailSubscriber::subscribedTo();

        $this->assertIsArray($array);
        $this->assertTrue(count($array) >= 1);
    }

}