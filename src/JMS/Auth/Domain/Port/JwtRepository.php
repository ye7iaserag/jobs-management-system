<?php

namespace JMS\Auth\Domain\Port;

use JMS\Auth\Domain\Entity\User;
use JMS\Auth\Domain\ValueObject\JwtToken;

interface JwtRepository
{
    public function getToken(User $user): ?JwtToken;

}
