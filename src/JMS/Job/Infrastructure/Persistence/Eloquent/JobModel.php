<?php

declare(strict_types=1);

namespace JMS\Job\Infrastructure\Persistence\Eloquent;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Shared\Infrastructure\Persistence\Eloquent\UserModel;

final class JobModel extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
    protected $table = 'job';
    public $incrementing = false;
    public $timestamps = false;

    protected static function newFactory()
    {
        return JobModelFactory::new();
    }

    public function owner() {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }
}
