<?php

declare(strict_types=1);

namespace JMS\Job\Application\CreateJob;

use Shared\Domain\Bus\Command\Command;

final class CreateJobCommand implements Command
{
    public function __construct(private string $id, private string $title, private string $description, private string $ownerId)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function ownerId(): string
    {
        return $this->ownerId;
    }

}
