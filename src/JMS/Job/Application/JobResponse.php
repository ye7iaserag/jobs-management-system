<?php

declare(strict_types=1);

namespace JMS\Job\Application;

use JMS\Job\Domain\Entity\Job;
use Shared\Domain\Bus\Query\Response;

final class JobResponse implements Response
{


    public function __construct(private string $id, private string $title, private string $description, private string $ownerId)
    {}

    public static function fromJob(Job $job): self
    {
        return new self(
            $job->id()->value(),
            $job->title()->value(),
            $job->description()->value(),
            $job->ownerId()->value(),
        );
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

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'ownerId' => $this->ownerId,
        ];
    }
}
