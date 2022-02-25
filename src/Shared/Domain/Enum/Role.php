<?php

namespace Shared\Domain\Enum;

enum Role: int
{
    case Manager = 1;
    case Regular = 2;
}