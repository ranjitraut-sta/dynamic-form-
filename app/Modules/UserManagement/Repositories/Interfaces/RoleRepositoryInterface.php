<?php
namespace App\Modules\UserManagement\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function getRoleNameByRoleId($id);
    public function getPermissionIdsByRoleId($id);
}
