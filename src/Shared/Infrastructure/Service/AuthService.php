<?php

namespace Shared\Infrastructure\Service;

use Illuminate\Support\Facades\Auth;
use Shared\Domain\Entity\Identity;
use Shared\Domain\Port\AuthService as AuthServiceInterface;

class AuthService implements AuthServiceInterface {

    public function getIdentity(): Identity {
        return Identity::fromPrimitives(Auth::user()->id, Auth::user()->role);
    }

}