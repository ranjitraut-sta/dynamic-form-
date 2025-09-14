<?php

namespace App\Modules\DynamicForm\Providers;

use Illuminate\Support\ServiceProvider;

class DynamicFormServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Service bindings will be added here
        $this->mergeConfigFrom(__DIR__ . '/../Config/dynamicform.php', 'dynamicform');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'dynamicform');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }
}