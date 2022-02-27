<?php

declare(strict_types=1);

namespace JMS\Job\Domain\DTO;

use JMS\Job\Domain\ValueObject\ { JobOwnerId };

final class JobsFiltration
{
    
    public function __construct(
        private ?JobOwnerId $ownerId
    ) {
    }

    public function ownerId(): ?JobOwnerId
    {
        return $this->ownerId;
    }
}
