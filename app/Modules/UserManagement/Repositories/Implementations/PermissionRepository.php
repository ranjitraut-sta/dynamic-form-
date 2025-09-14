<?php

namespace App\Modules\UserManagement\Repositories\Implementations;

use App\Core\Repositories\Implementation\BaseRepository;
use App\Modules\UserManagement\Models\Permission;
use App\Modules\UserManagement\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function __construct(Permission $model)
    {
        parent::__construct($model);
    }

    public function getAllPermission()
    {
        $permissions = $this->model->select('id', 'name', 'group_name', 'action', 'controller')->get();

        // Grouping the data by groupname using Laravel's collection method
        return $permissions->groupBy('group_name');
    }


}
