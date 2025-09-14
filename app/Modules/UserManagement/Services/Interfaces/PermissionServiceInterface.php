<?php

namespace App\Modules\UserManagement\Services\Interfaces;

use App\Core\Services\Interface\BaseServiceInterface;

interface PermissionServiceInterface extends BaseServiceInterface
{
    public function getAllPermission();
}
