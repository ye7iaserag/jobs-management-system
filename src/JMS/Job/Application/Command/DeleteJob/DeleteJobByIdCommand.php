<?php

declare(strict_types=1);

namespace JMS\Job\Application\Command\DeleteJob;

use Shared\Domain\Bus\Command\Command;

final class DeleteJobByIdCommand implements Command
{
    public function __construct(private string $id)
    {
    }

    public function id(): string
    {
        return $this->id;
    }
}
