<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Constants;

class Error
{
    const UNAUTHORIZED_ACCESS = 1;
    const INVALID_INPUTS = 2;
    const UNKNOWN_ERROR = 3;
    const TOKEN_EXPIRED = 4;
    const TOKEN_INVALID = 5;
    const HANDLER_FAILED = 6;

    const MSG = [
        Error::UNAUTHORIZED_ACCESS => 'Unauthorized access',
        Error::INVALID_INPUTS => 'Invalid inputs',
        Error::UNKNOWN_ERROR => 'Unknown error',
        Error::TOKEN_EXPIRED => 'Token expired',
        Error::TOKEN_INVALID => 'Token invalid',
        Error::HANDLER_FAILED => 'Handler failed with domain error',
    ];
}
