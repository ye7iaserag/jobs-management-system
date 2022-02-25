<?php

declare(strict_types=1);

namespace JMS\Job\Domain\Entity;

use JMS\Job\Domain\ValueObject\ { JobOwnerId, JobOwnerName };

final class JobOwner
{
    public function __construct(
        private JobOwnerId $id,
        private JobOwnerName $name,
    ) {
    }

    public static function fromPrimitives(string $id, string $name): self
    {
        return new self(
            JobOwnerId::fromValue($id),
            JobOwnerName::fromValue($name)
        );
    }

    public function id(): JobOwnerId
    {
        return $this->id;
    }

    public function name(): JobOwnerName
    {
        return $this->name;
    }
}
