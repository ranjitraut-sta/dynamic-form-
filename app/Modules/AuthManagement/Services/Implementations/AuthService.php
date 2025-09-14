<?php

namespace App\Modules\AuthManagement\Services\Implementations;

use App\Core\Services\Implementation\BaseService;
use App\Modules\AuthManagement\Repositories\Interfaces\AuthRepositoryInterface;
use App\Modules\AuthManagement\Services\Interfaces\AuthServiceInterface;

class AuthService extends BaseService implements AuthServiceInterface
{
    public function __construct(AuthRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function sendResetLink($email)
    {
        return $this->repository->sendResetLink($email);
    }
}
