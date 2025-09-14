<?php

namespace App\Modules\UserManagement\Services\Interfaces;

use App\Core\Services\Interface\BaseServiceInterface;

interface RoleServiceInterface extends BaseServiceInterface
{
    public function getRoleNameByRoleId(int $id): string;
    public function getPermissionIdsByRoleId(int $id): array; // Assuming it returns an array of permission IDs
    public function getPaginatedSearchResults(int $perPage, ?string $search = null);
}
