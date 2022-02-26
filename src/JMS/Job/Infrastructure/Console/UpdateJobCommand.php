<?php

namespace JMS\Job\Infrastructure\Console;

use Illuminate\Console\Command;
use JMS\Job\Application\CreateJob\CreateJobCommand as CreateJobCreateJobCommand;
use JMS\Job\Application\UpdateJob\UpdateJobCommand as UpdateJobUpdateJobCommand;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\Port\UuidGenerator;

class UpdateJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:update {id} {title} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update job';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private CommandBus $commandBus)
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
        $id = $this->argument('id');
        $this->commandBus->dispatch(
            new UpdateJobUpdateJobCommand(
                $id,
                $this->argument('title'),
                $this->argument('description')
            )
        );
        $this->info(json_encode($id));
        return 0;
    }
}
