<?php

namespace JMS\Job\Infrastructure\Console;

use Illuminate\Console\Command;
use JMS\Job\Application\Query\GetJob\GetJobByIdQuery;
use JMS\Job\Application\Query\ListJobs\ListJobsQuery;
use JMS\Job\Domain\DTO\JobsFiltration;
use Shared\Domain\Bus\Query\QueryBus;

class ListJobsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get jobs list';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private QueryBus $queryBus)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $jobResponse = $this->queryBus->ask(
            new ListJobsQuery(new JobsFiltration(null))
        );
        $this->info(json_encode($jobResponse));
        return 0;
    }
}
