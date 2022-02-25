<?php

declare(strict_types=1);

namespace JMS\Job\Application\GetJob;

use Shared\Domain\Bus\Query\Query;

final class GetJobByIdQuery implements Query
{
    public function __construct(private string $id)
    {
    }

    public function id(): string
    {
        return $this->id;
    }
}
