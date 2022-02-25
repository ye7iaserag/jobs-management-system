<?php

namespace JMS\Auth\Domain;

use JMS\Auth\Domain\ValueObject\UserPassword;

interface HashService
{
    public function check(UserPassword $plainPassword, UserPassword $hash): bool;

}
