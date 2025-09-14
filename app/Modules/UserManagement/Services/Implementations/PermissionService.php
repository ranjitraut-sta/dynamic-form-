<?php

namespace App\Modules\UserManagement\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Core\Traits\HasPaginatedSearch;
use App\Modules\UserManagement\DTOs\Permission\PermissionDto;
use App\Modules\UserManagement\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Modules\UserManagement\Services\Interfaces\PermissionServiceInterface;

class PermissionService extends BaseService implements PermissionServiceInterface
{
    use HasPaginatedSearch;
    public function __construct(PermissionRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function getAllPermission()
    {
        $baseQuery = $this->repository->getAllPermission();
        return $baseQuery;
    }
}
