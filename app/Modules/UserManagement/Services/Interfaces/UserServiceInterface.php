<?php

namespace App\Modules\UserManagement\Services\Interfaces;

use App\Core\Services\Interface\BaseServiceInterface;

interface UserServiceInterface extends BaseServiceInterface
{
    public function getPaginatedSearchResults(int $perPage, ?string $search = null);
}
