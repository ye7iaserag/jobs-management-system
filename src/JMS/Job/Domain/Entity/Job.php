<?php

declare(strict_types=1);

namespace JMS\Job\Domain\Entity;

use Shared\Domain\Aggregate\AggregateRoot;
use JMS\Job\Domain\ValueObject\ { JobId, JobTitle, JobDescription, JobOwnerId, JobOwnerName };
use JMS\Job\Domain\Event\JobCreated;
use JMS\Job\Domain\Event\JobDeleted;
use JMS\Job\Domain\Event\JobUpdated;

final class Job extends AggregateRoot
{
    public function __construct(
        private JobId $id,
        private JobTitle $title,
        private JobDescription $description,
        private JobOwnerId $ownerId,
        private ?JobOwner $owner = null
    ) {
    }

    public static function fromPrimitives(string $id, string $title, string $description, string $ownerId, ?JobOwner $owner = null): self
    {
        return new self(
            JobId::fromValue($id),
            JobTitle::fromValue($title),
            JobDescription::fromValue($description),
            JobOwnerId::fromValue($ownerId),
            $owner
        );
    }

    public function id(): JobId
    {
        return $this->id;
    }

    public function title(): JobTitle
    {
        return $this->title;
    }

    public function description(): JobDescription
    {
        return $this->description;
    }

    public function ownerId(): JobOwnerId
    {
        return $this->ownerId;
    }

    public function owner(): ?JobOwner
    {
        return $this->owner;
    }

    static public function make(JobId $id, JobTitle $title, JobDescription $description, JobOwnerId $ownerId): self
    {
        $entity = new self($id, $title, $description, $ownerId);
        $entity->record(new JobCreated($id->value()));
        
        return $entity;
    }
    
    
    /**
     * modify
     *
     *
     * @param NoteText $text
     *
     * @return void
     */
    public function modify(JobTitle $title, JobDescription $description): void
    {
        $this->title        = $title;
        $this->description = $description;
        
        $this->record(new JobUpdated($this->id()->value()));
    }
    
    /**
     * Delete
     *
     *
     * @return void
     */
    public function delete(): void
    {
        $this->record(new JobDeleted($this->id()->value()));
    }
}
