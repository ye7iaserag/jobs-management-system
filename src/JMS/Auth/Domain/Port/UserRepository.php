<?php

namespace JMS\Auth\Domain\Port;

use JMS\Auth\Domain\Entity\User;
use JMS\Auth\Domain\DTO\Users;
use JMS\Auth\Domain\DTO\UsersFiltration;
use JMS\Auth\Domain\ValueObject\UserEmail;

interface UserRepository
{
    public function findByEmail(UserEmail $email): ?User;

    public function list(UsersFiltration $filtration): Users;

}
