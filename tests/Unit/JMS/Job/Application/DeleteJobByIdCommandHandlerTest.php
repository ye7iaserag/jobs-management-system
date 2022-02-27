<?php

declare(strict_types=1);

namespace Tests\Unit\JMS\Job\Application;

use Illuminate\Foundation\Testing\WithFaker;
use JMS\Job\Application\Command\DeleteJob\DeleteJobByIdCommand;
use JMS\Job\Application\Command\DeleteJob\DeleteJobByIdCommandHandler;
use JMS\Job\Domain\Entity\Job;
use JMS\Job\Domain\Exceptions\JobNotFound;
use JMS\Job\Domain\Port\JobRepository;
use Tests\TestCase;

final class DeleteJobByIdCommandHandlerTest extends TestCase
{
    use WithFaker;

    function test_create_delete_job_by_id_command_handler()
    {
        $this->mock(JobRepository::class, fn ($mock) => $mock->shouldReceive('find')->once()->andReturn(Job::fromPrimitives($this->faker->uuid(), $this->faker->name(), $this->faker->name(), $this->faker->uuid()))->shouldReceive('delete'));

        $jobRepoMock = $this->app->make(JobRepository::class);

        $command = new DeleteJobByIdCommand($this->faker->uuid());

        $handler = new DeleteJobByIdCommandHandler($jobRepoMock);

        $handler($command);
    }

    function test_delete_job_by_id_command_handler_existing_job()
    {
        $this->mock(JobRepository::class, fn ($mock) => $mock->shouldReceive('find')->once()->andReturn(null)->shouldReceive('delete'));

        $this->expectException(JobNotFound::class);

        $jobRepoMock = $this->app->make(JobRepository::class);

        $command = new DeleteJobByIdCommand($this->faker->uuid());

        $handler = new DeleteJobByIdCommandHandler($jobRepoMock);

        $handler($command);
    }

}