<?php

namespace Shared\Domain\Port;

use Shared\Domain\Entity\Identity;

interface AuthService {

    public function getIdentity(): Identity;

}