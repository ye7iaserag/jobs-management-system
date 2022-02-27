<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\Command\CreateJob\CreateJobCommand;
use JMS\Job\Application\Command\CreateJob\CreateJobCommandHandler;
use JMS\Job\Domain\Entity\Job;
use JMS\Job\Domain\Exceptions\JobAlreadyExists;
use JMS\Job\Domain\Port\JobRepository;
use Shared\Domain\Bus\Event\EventBus;
use Tests\TestCase;

final class CreateJobCommandHandlerTest extends TestCase
{
    use WithFaker;

    function test_create_create_job_command_handler()
    {
        $this->mock(JobRepository::class, fn ($mock) => $mock->shouldReceive('find')->once()->andReturn(null)->shouldReceive('save'));
        $this->mock(EventBus::class, fn ($mock) => $mock->shouldReceive('publish'));

        $jobRepoMock = $this->app->make(JobRepository::class);
        $eventBusMock = $this->app->make(EventBus::class);

        $command = new CreateJobCommand($this->faker->uuid(), $this->faker->name(), $this->faker->name(), $this->faker->uuid());

        $handler = new CreateJobCommandHandler($jobRepoMock, $eventBusMock);

        $handler($command);
    }

    function test_create_job_command_handler_existing_job()
    {
        $this->mock(JobRepository::class, fn ($mock) => $mock->shouldReceive('find')->once()->andReturn(Job::fromPrimitives($this->faker->uuid(), $this->faker->name(), $this->faker->name(), $this->faker->uuid()))->shouldReceive('save'));
        $this->mock(EventBus::class, fn ($mock) => $mock->shouldReceive('publish'));

        $this->expectException(JobAlreadyExists::class);

        $jobRepoMock = $this->app->make(JobRepository::class);
        $eventBusMock = $this->app->make(EventBus::class);

        $command = new CreateJobCommand($this->faker->uuid(), $this->faker->name(), $this->faker->name(), $this->faker->uuid());

        $handler = new CreateJobCommandHandler($jobRepoMock, $eventBusMock);

        $handler($command);
    }

}