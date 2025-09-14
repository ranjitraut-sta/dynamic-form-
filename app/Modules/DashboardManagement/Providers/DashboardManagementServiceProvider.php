<?php

        namespace App\Modules\DashboardManagement\Providers;

        use Illuminate\Support\ServiceProvider;
        use App\Modules\DashboardManagement\Services\Interfaces\DashboardManagementServiceInterface;
        use App\Modules\DashboardManagement\Services\Implementations\DashboardManagementService;
        use App\Modules\DashboardManagement\Repositories\Interfaces\DashboardManagementRepositoryInterface;
        use App\Modules\DashboardManagement\Repositories\Implementations\DashboardManagementRepository;

        class DashboardManagementServiceProvider extends ServiceProvider
        {
            public function register()
            {
                $this->app->bind(DashboardManagementServiceInterface::class, DashboardManagementService::class);
                $this->app->bind(DashboardManagementRepositoryInterface::class, DashboardManagementRepository::class);
                $this->mergeConfigFrom(__DIR__ . '/../Config/dashboardmanagement.php', 'dashboardmanagement');
            }

            public function boot()
            {
                $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
                $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'dashboardmanagement');
                $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
                $this->publishes([
                    __DIR__ . '/../Resources/assets' => public_path('modules/dashboardmanagement'),
                    ], 'dashboardmanagement-assets');
                }
        }