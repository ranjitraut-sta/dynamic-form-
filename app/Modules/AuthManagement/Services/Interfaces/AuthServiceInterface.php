<?php

namespace App\Modules\AuthManagement\Services\Interfaces;

use App\Core\Services\Interface\BaseServiceInterface;

interface AuthServiceInterface extends BaseServiceInterface
{
    public function sendResetLink($email);
}
