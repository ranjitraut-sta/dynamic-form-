<?php
namespace App\Modules\UserManagement\Repositories\Interfaces;

use App\Core\Repositories\Interface\BaseRepositoryInterface;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function getUsers();
    public function keepLastLogin($userId);
}
