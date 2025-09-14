<?php

namespace App\Modules\AuthManagement\Providers;

use App\Modules\AuthManagement\Repositories\Implementations\AuthRepository;
use App\Modules\AuthManagement\Repositories\Implementations\LoginRepository;
use App\Modules\AuthManagement\Repositories\Interfaces\AuthRepositoryInterface;
use App\Modules\AuthManagement\Repositories\Interfaces\LoginRepositoryInterface;
use App\Modules\AuthManagement\Services\Implementations\AuthService;
use App\Modules\AuthManagement\Services\Implementations\LoginService;
use App\Modules\AuthManagement\Services\Interfaces\AuthServiceInterface;
use App\Modules\AuthManagement\Services\Interfaces\LoginServiceInterface;
use Illuminate\Support\ServiceProvider;

class AuthManagementServiceProvider extends ServiceProvider
{
    public function register()
    {
        //binding repository
        $this->app->bind(LoginRepositoryInterface::class, LoginRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);

        //binding service
        $this->app->bind(LoginServiceInterface::class, LoginService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);

    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'AuthManagement');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}
