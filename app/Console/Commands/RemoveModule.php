<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class RemoveModule extends Command
{
    protected $signature = 'module:remove {name} {--force : Skip confirmation}';
    protected $description = 'Remove a module and all its files';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $basePath = app_path("Modules/{$name}");

        if (!File::exists($basePath)) {
            $this->error("Module '{$name}' does not exist.");
            return;
        }

        if (!$this->option('force') && !$this->confirm("Are you sure you want to remove module '{$name}' and all its files?")) {
            $this->info('Operation cancelled.');
            return;
        }

        // Remove module directory
        File::deleteDirectory($basePath);

        $this->info("✅ Module '{$name}' removed successfully.");
        $this->warn("⚠️  Don't forget to:");
        $this->warn("   - Remove ServiceProvider from config/app.php");
        $this->warn("   - Run migration rollback if needed");
        $this->warn("   - Clear cache: php artisan optimize:clear");
    }
}