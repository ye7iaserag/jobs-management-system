<?php

namespace Shared\Domain\Port;

interface UuidGenerator
{
    public function generate(): string;
}
