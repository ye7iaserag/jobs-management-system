<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Constants;

use Illuminate\Http\Response;

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

    const HTTP_CODE = [
        Error::UNAUTHORIZED_ACCESS => Response::HTTP_UNAUTHORIZED,
        Error::INVALID_INPUTS => Response::HTTP_UNPROCESSABLE_ENTITY,
        Error::UNKNOWN_ERROR => Response::HTTP_INTERNAL_SERVER_ERROR,
        Error::TOKEN_EXPIRED => Response::HTTP_UNAUTHORIZED,
        Error::TOKEN_INVALID => Response::HTTP_NOT_FOUND,
        Error::HANDLER_FAILED => Response::HTTP_UNPROCESSABLE_ENTITY,
    ];
}
