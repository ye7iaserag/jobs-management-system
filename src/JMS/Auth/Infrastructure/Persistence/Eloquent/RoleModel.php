<?php

declare(strict_types=1);

namespace JMS\Auth\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{

    protected $table = 'role';

    public $incrementing = false;


}
