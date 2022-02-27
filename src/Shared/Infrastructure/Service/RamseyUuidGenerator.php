<?php

namespace Shared\Infrastructure\Service;

use Shared\Domain\Port\UuidGenerator;
use Ramsey\Uuid\Uuid as RamseyUuid;

final class RamseyUuidGenerator implements UuidGenerator
{
    public function generate(): string
    {
        return RamseyUuid::uuid4()->toString();
    }
}
