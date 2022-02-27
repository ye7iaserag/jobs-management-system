<?php

declare(strict_types=1);

namespace App\Providers;

use JMS\Job\Application\CreateJob\CreateJobCommandHandler;
use JMS\Job\Application\DeleteJob\DeleteJobByIdCommandHandler;
use JMS\Job\Application\GetJob\GetJobByIdQueryHandler;
use JMS\Job\Application\ListJobs\ListJobsQueryHandler;
use JMS\Job\Application\UpdateJob\UpdateJobCommandHandler;
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
