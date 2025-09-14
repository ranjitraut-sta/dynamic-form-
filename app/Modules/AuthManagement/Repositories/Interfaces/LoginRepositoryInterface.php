<?php

namespace App\Modules\AuthManagement\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface LoginRepositoryInterface extends BaseRepositoryInterface
{
    public function checkLoginCredential($request);
}
