<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ModuleMigrate extends Command
{
    // php artisan module:migrate ModuleName
    protected $signature = 'module:migrate {module}';
    protected $description = 'Run only the migrations of a specific module';

    public function handle()
    {
        $module = ucfirst($this->argument('module'));
        $migrationPath = app_path("Modules/{$module}/Database/Migrations");

        if (!File::exists($migrationPath)) {
            $this->error("Migration path not found for module: {$module}");
            return;
        }

        $this->info("Running migrations for module: {$module}");
        Artisan::call('migrate', [
            '--path' => "app/Modules/{$module}/Database/Migrations",
            '--realpath' => true
        ]);

        $this->info(Artisan::output());
    }
}
