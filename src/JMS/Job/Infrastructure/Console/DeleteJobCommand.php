<?php

namespace JMS\Job\Infrastructure\Console;

use Illuminate\Console\Command;
use JMS\Job\Application\Command\CreateJob\CreateJobCommand as CreateJobCreateJobCommand;
use JMS\Job\Application\Command\DeleteJob\DeleteJobByIdCommand;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\Port\UuidGenerator;

class DeleteJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:delete {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete job';

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
            new DeleteJobByIdCommand(
                $id
            )
        );
        $this->info(json_encode($id));
        return 0;
    }
}
