<?php

namespace App\Modules\AuthManagement\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface AuthRepositoryInterface extends BaseRepositoryInterface
{
    public function sendResetLink($email);
}
