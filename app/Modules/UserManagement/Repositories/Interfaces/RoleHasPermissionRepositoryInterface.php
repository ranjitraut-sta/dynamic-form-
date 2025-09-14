<?php

namespace App\Modules\UserManagement\Repositories\Interfaces;

interface RoleHasPermissionRepositoryInterface
{
    public function getModel();
    public function createRecord(array $data);
}
