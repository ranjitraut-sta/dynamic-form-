<?php

namespace App\Providers;

use App\Core\Services\Implementation\AccessService;
use App\Core\Services\Implementation\FileUploadService;
use App\Core\Services\Interface\FileUploadServiceInterface;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Services Bindings
        $this->app->bind(FileUploadServiceInterface::class, FileUploadService::class);

        // Modules Providers
        foreach (File::directories(app_path('Modules')) as $module) {
            $moduleName = basename($module);
            $provider = "App\\Modules\\{$moduleName}\\Providers\\{$moduleName}ServiceProvider";

            if (class_exists($provider)) {
                $this->app->register($provider);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('canAccess', function ($params) {
            [$controller, $action] = $params;
            return app(AccessService::class)->userHasPermission(auth()->user(), $controller, $action);
        });
    }
}
