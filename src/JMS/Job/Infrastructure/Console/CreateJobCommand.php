<?php

namespace JMS\Job\Infrastructure\Console;

use Illuminate\Console\Command;
use JMS\Job\Application\CreateJob\CreateJobCommand as CreateJobCreateJobCommand;
use Shared\Domain\Bus\Command\CommandBus;
use Shared\Domain\Port\UuidGenerator;

class CreateJobCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:create {id} {title} {description} {ownerId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create job';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private CommandBus $commandBus, private UuidGenerator $uuidGenerator)
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
        $id = $this->uuidGenerator->generate();
        $this->commandBus->dispatch(
            new CreateJobCreateJobCommand(
                $id,
                $this->argument('title'),
                $this->argument('description'),
                $this->argument('ownerId')
            )
        );
        $this->info(json_encode($id));
        return 0;
    }
}
