<?php

namespace JMS\Job\Infrastructure\Console;

use Illuminate\Console\Command;
use JMS\Job\Application\GetJob\GetJobByIdQuery;
use Shared\Domain\Bus\Query\QueryBus;

class GetJobByIdCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:get {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get job by id';

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
            new GetJobByIdQuery($this->argument('id'))
        );
        $this->info(json_encode($jobResponse));
        return 0;
    }
}
