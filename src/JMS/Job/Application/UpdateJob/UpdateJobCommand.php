<?php

declare(strict_types=1);

namespace JMS\Job\Application\UpdateJob;

use Shared\Domain\Bus\Command\Command;

final class UpdateJobCommand implements Command
{
    public function __construct(private string $id, private string $title, private string $description)
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
}
