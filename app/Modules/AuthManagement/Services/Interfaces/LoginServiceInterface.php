<?php

namespace App\Modules\AuthManagement\Services\Interfaces;

use App\Core\Services\Interface\BaseServiceInterface;


interface LoginServiceInterface extends BaseServiceInterface
{
    public function checkLoginCredential($request,$type);
}
