<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleModel extends Command
{
    // Support: php artisan module:make-model ModuleName ModelName -m
    protected $signature = 'module:make-model {module} {name} {--m|migration}';
    protected $description = 'Create a new model inside a module (with optional migration)';

    public function handle()
    {
        $module = Str::studly($this->argument('module'));
        $name = Str::studly($this->argument('name'));
        $path = app_path("Modules/{$module}/Models");

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $modelContent = <<<PHP
        <?php

        namespace App\Modules\\{$module}\Models;

        use Illuminate\Database\Eloquent\Model;
        use Illuminate\Database\Eloquent\Factories\HasFactory;

        class {$name} extends Model
        {
            use HasFactory;

            protected \$guarded = [];
        }
        PHP;

        File::put("{$path}/{$name}.php", trim($modelContent));
        $this->info("✅ Model '{$name}' created inside module '{$module}'.");

        if ($this->option('migration') || $this->option('m')) {
            $this->createMigration($module, $name);
        }
    }

    protected function createMigration(string $module, string $model): void
    {
        $tableName = Str::snake(Str::pluralStudly($model));
        $timestamp = now()->format('Y_m_d_His');
        $className = 'Create' . Str::pluralStudly($model) . 'Table';
        $migrationPath = app_path("Modules/{$module}/Database/Migrations");

        if (!File::exists($migrationPath)) {
            File::makeDirectory($migrationPath, 0755, true);
        }

        $migrationContent = <<<PHP
        <?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        return new class extends Migration
        {
            public function up(): void
            {
                Schema::create('$tableName', function (Blueprint \$table) {
                    \$table->id();
                    \$table->timestamps();
                });
            }

            public function down(): void
            {
                Schema::dropIfExists('$tableName');
            }
        };
        PHP;

        File::put("{$migrationPath}/{$timestamp}_create_{$tableName}_table.php", trim($migrationContent));
        $this->info("📦 Migration created for table '{$tableName}' at Modules/{$module}/Database/Migrations/");
    }
}
