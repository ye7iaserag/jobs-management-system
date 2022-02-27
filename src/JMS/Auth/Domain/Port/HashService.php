<?php

namespace JMS\Auth\Domain\Port;

use JMS\Auth\Domain\ValueObject\UserPassword;

interface HashService
{
    public function check(UserPassword $plainPassword, UserPassword $hash): bool;

}
