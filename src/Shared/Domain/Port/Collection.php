<?php

declare(strict_types=1);

namespace Shared\Domain\Port;

abstract class Collection implements CollectionInterface
{
    private array $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    public function all(): array
    {
        return $this->items;
    }
}
