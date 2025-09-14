<?php

namespace App\Modules\UserManagement\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\UserManagement\Models\RoleHasPermission;
use App\Modules\UserManagement\Repositories\Interfaces\RoleHasPermissionRepositoryInterface;

class RoleHasPermissionRepository extends BaseRepository implements RoleHasPermissionRepositoryInterface
{
    protected $model;

    public function __construct(RoleHasPermission $model)
    {
        parent::__construct($model);
    }
}
