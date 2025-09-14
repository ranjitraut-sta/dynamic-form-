<?php

namespace App\Modules\UserManagement\Providers;

use App\Modules\UserManagement\Repositories\Implementations\PermissionRepository;
use App\Modules\UserManagement\Repositories\Implementations\RoleHasPermissionRepository;
use App\Modules\UserManagement\Repositories\Implementations\RoleRepository;
use App\Modules\UserManagement\Repositories\Implementations\UserRepository;
use App\Modules\UserManagement\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Modules\UserManagement\Repositories\Interfaces\RoleHasPermissionRepositoryInterface;
use App\Modules\UserManagement\Repositories\Interfaces\RoleRepositoryInterface;
use App\Modules\UserManagement\Repositories\Interfaces\UserRepositoryInterface;
use App\Modules\UserManagement\Services\Implementations\PermissionService;
use App\Modules\UserManagement\Services\Implementations\RoleService;
use App\Modules\UserManagement\Services\Implementations\UserService;
use App\Modules\UserManagement\Services\Interfaces\PermissionServiceInterface;
use App\Modules\UserManagement\Services\Interfaces\RoleServiceInterface;
use App\Modules\UserManagement\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\ServiceProvider;

class UserManagementServiceProvider extends ServiceProvider
{
    public function register()
    {
        // merge config
        $this->mergeConfigFrom(__DIR__ . '/../Config/usermanagement.php', 'UserManagement');
        //binding repository
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
        $this->app->bind(RoleHasPermissionRepositoryInterface::class, RoleHasPermissionRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        //binding service
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(PermissionServiceInterface::class, PermissionService::class);







}

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'UserManagement');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
