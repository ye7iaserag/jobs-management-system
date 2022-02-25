<?php

declare(strict_types=1);

namespace JMS\Auth\Application;

use JMS\Auth\Domain\ValueObject\JwtToken;
use Shared\Domain\Bus\Query\Response;

final class LoginResponse implements Response
{

    public function __construct(private string $token)
    {}

    public static function fromJwtToken(JwtToken $token): self
    {
        return new self(
            $token->value(),
        );
    }

    public function token(): string
    {
        return $this->token;
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
        ];
    }
}
