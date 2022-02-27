<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Providers;

use JMS\Job\Application\Command\CreateJob\CreateJobCommandHandler;
use JMS\Job\Application\Command\DeleteJob\DeleteJobByIdCommandHandler;
use JMS\Job\Application\Query\GetJob\GetJobByIdQueryHandler;
use JMS\Job\Application\Query\ListJobs\ListJobsQueryHandler;
use JMS\Job\Application\Command\UpdateJob\UpdateJobCommandHandler;
use JMS\Job\Domain\Port\JobRepository;
use JMS\Job\Infrastructure\Persistence\Eloquent\JobRepository as EloquentJobRepository;
use Illuminate\Support\ServiceProvider;


final class JobServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            JobRepository::class,
            EloquentJobRepository::class
        );

        $this->app->tag(
            CreateJobCommandHandler::class,
            'command_handler'
        );

        $this->app->tag(
            DeleteJobByIdCommandHandler::class,
            'command_handler'
        );

        $this->app->tag(
            GetJobByIdQueryHandler::class,
            'query_handler'
        );

        $this->app->tag(
            ListJobsQueryHandler::class,
            'query_handler'
        );

        $this->app->tag(
            UpdateJobCommandHandler::class,
            'command_handler'
        );
    }
}
