<?php

namespace App\Core\Helpers;

use Illuminate\Support\Facades\Artisan;

class ModuleMigrateHelper
{
    /**
     * Run migrations for a specific module.
     *
     * @param string $moduleName
     * @return string
     */
    public static function migrate(string $moduleName): string
    {
        $path = base_path("app/Modules/{$moduleName}/Database/Migrations");

        if (!is_dir($path)) {
            return "❌ Module '{$moduleName}' does not exist or has no migrations.";
        }

        Artisan::call('migrate', [
            '--path' => "app/Modules/{$moduleName}/Database/Migrations",
            '--force' => true,
        ]);

        return Artisan::output();
    }

    /**
     * Run migrations for all modules.
     *
     * @return array
     */
    public static function migrateAll(): array
    {
        $modulesPath = base_path("app/Modules");
        $results = [];

        foreach (scandir($modulesPath) as $module) {
            if ($module === '.' || $module === '..') continue;

            $migrationPath = "{$modulesPath}/{$module}/Database/Migrations";
            if (is_dir($migrationPath)) {
                Artisan::call('migrate', [
                    '--path' => "app/Modules/{$module}/Database/Migrations",
                    '--force' => true,
                ]);
                $results[$module] = Artisan::output();
            }
        }

        return $results;
    }
}
