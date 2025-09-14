<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModule extends Command
{
    protected $signature = 'module:make {name} {--with-crud= : Generate module with sample CRUD entity}';
    protected $description = 'Create a new module with clean architecture. Use --with-crud=EntityName for sample CRUD';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));
        $slug = Str::slug($name);
        $lowerName = strtolower($name);
        $basePath = app_path("Modules/{$name}");

        $folders = [
            'Controllers',
            'DTOs',
            'Models',
            'Requests',
            'Resources/views',
            'Routes',
            'Providers',
            'Services/Interfaces',
            'Services/Implementations',
            'Repositories/Interfaces',
            'Repositories/Implementations',
            'Database/Migrations',
            'Database/Seeders',
            'Traits',
            'Config',
            'Enums',
            'Constants',
            'Resources/assets/css',
            'Resources/assets/js',
            'Resources/assets/images',
        ];

        foreach ($folders as $folder) {
            File::ensureDirectoryExists("{$basePath}/{$folder}");
        }

        // Only create basic structure - CRUD entities added separately
        $this->createProvider($basePath, $name);
        $this->createBasicRoute($basePath, $name);
        $this->createModuleDatabaseSeeder($basePath, $name);
        $this->createTrait($basePath, $name);
        $this->createConfig($basePath, $name);
        $this->createAssets($basePath, $name);
        $this->createEnum($basePath, $name);
        $this->createUploadPaths($basePath, $name);

        // Generate sample CRUD if requested
        if ($crudEntity = $this->option('with-crud')) {
            $this->info("🔄 Generating sample CRUD for '{$crudEntity}'...");
            $this->call('module:make-crud', [
                'module' => $name,
                'entity' => $crudEntity
            ]);
        }

        $this->info("✅ Module '{$name}' created successfully at: Modules/{$name}");
        if ($crudEntity) {
            $this->info("📝 Sample CRUD '{$crudEntity}' included. Run: php artisan migrate");
        } else {
            $this->info("📝 Add entities with: php artisan module:make-crud {$name} EntityName");
        }
    }

    protected function createController($path, $name)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\$name\Controllers;

        use App\Http\Controllers\Controller;
        use Illuminate\Http\Request;
        use App\Modules\\$name\Services\Interfaces\\{$name}ServiceInterface;

        class {$name}Controller extends Controller
        {
            protected \$service;

            public function __construct({$name}ServiceInterface \$service)
            {
                \$this->service = \$service;
            }

            public function index()
            {
                \$data = \$this->service->getAll();
                return view('{$this->getViewAlias($name)}::index', compact('data'));
            }
        }
        PHP;

        File::put("$path/Controllers/{$name}Controller.php", trim($content));
    }

    protected function createServiceInterface($path, $name)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\$name\Services\Interfaces;

        interface {$name}ServiceInterface
        {
            public function getAll();
        }
        PHP;

        File::put("$path/Services/Interfaces/{$name}ServiceInterface.php", trim($content));
    }

    protected function createServiceImpl($path, $name)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\$name\Services\Implementations;

        use App\Modules\\$name\Services\Interfaces\\{$name}ServiceInterface;
        use App\Modules\\$name\Repositories\Interfaces\\{$name}RepositoryInterface;

        class {$name}Service implements {$name}ServiceInterface
        {
            protected \$repo;

            public function __construct({$name}RepositoryInterface \$repo)
            {
                \$this->repo = \$repo;
            }

            public function getAll()
            {
                return \$this->repo->getAll();
            }
        }
        PHP;

        File::put("$path/Services/Implementations/{$name}Service.php", trim($content));
    }

    protected function createRepoInterface($path, $name)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\$name\Repositories\Interfaces;

        interface {$name}RepositoryInterface
        {
            public function getAll();
        }
        PHP;

        File::put("$path/Repositories/Interfaces/{$name}RepositoryInterface.php", trim($content));
    }

    protected function createRepoImpl($path, $name)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\$name\Repositories\Implementations;

        use App\Modules\\$name\Repositories\Interfaces\\{$name}RepositoryInterface;

        class {$name}Repository implements {$name}RepositoryInterface
        {
            public function getAll()
            {
                return []; // Replace with model logic
            }
        }
        PHP;

        File::put("$path/Repositories/Implementations/{$name}Repository.php", trim($content));
    }

    protected function createDto($path, $name)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\$name\DTOs;

        class {$name}DTO
        {
            public string \$example;

            public function __construct(string \$example)
            {
                \$this->example = \$example;
            }

            public static function fromArray(array \$data): self
            {
                return new self(
                    \$data['example'] ?? ''
                );
            }

            public function toArray(): array
            {
                return ['example' => \$this->example];
            }
        }
        PHP;

        File::put("$path/DTOs/{$name}DTO.php", trim($content));
    }

    protected function createProvider($path, $name)
    {
        $lowerName = strtolower($name);

        $content = <<<PHP
        <?php

        namespace App\Modules\\$name\Providers;

        use Illuminate\Support\ServiceProvider;

        class {$name}ServiceProvider extends ServiceProvider
        {
            public function register()
            {
                // Service bindings will be added here
                \$this->mergeConfigFrom(__DIR__ . '/../Config/{$lowerName}.php', '{$lowerName}');
            }

            public function boot()
            {
                \$this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');
                \$this->loadViewsFrom(__DIR__ . '/../Resources/views', '{$lowerName}');
                \$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
            }
        }
        PHP;

        File::put("$path/Providers/{$name}ServiceProvider.php", trim($content));
    }

    protected function createBasicRoute($path, $name)
    {
        $lowerName = strtolower($name);

        $route = <<<PHP
        <?php

        use Illuminate\Support\Facades\Route;

        Route::middleware(['web', 'auth'])->prefix('admin')->group(function () {
            // Module routes will be added here
        });
        PHP;

        File::put("$path/Routes/web.php", trim($route));
    }

    protected function createView($path, $name)
    {
        // php artisan vendor:publish --tag=role-assets
        $content = "<h1>{$name} Module</h1>\n<p>Welcome to the {$name} module view!</p>";
        File::put("$path/Resources/views/index.blade.php", $content);
    }

    protected function createMigration($path, $name)
    {
        $table = Str::snake(Str::plural($name));
        $timestamp = now()->format('Y_m_d_His');
        $className = 'Create' . Str::plural($name) . 'Table';

        $content = <<<PHP
        <?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        return new class extends Migration
        {
            public function up(): void
            {
                Schema::create('$table', function (Blueprint \$table) {
                    \$table->id();
                    \$table->string('example_field');
                    \$table->timestamps();
                });
            }

            public function down(): void
            {
                Schema::dropIfExists('$table');
            }
        };
        PHP;

        File::put("$path/Database/Migrations/{$timestamp}_create_{$table}_table.php", trim($content));
    }

    protected function createModuleDatabaseSeeder($path, $name)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\$name\Database\Seeders;

        use Illuminate\Database\Seeder;

        class DatabaseSeeder extends Seeder
        {
            public function run(): void
            {
                // \$this->call([{$name}Seeder::class]); // Uncomment after creating seeder
            }
        }
        PHP;

        File::put("$path/Database/Seeders/DatabaseSeeder.php", trim($content));
    }

    protected function createTrait($path, $name)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\$name\Traits;

        trait {$name}Trait
        {
            public function exampleMethod()
            {
                // Define common functionality here
            }
        }
        PHP;

        File::put("$path/Traits/{$name}Trait.php", trim($content));
    }

    protected function createConfig($path, $name)
    {
        $lower = strtolower($name);
        $content = <<<PHP
        <?php

        return [
            'name' => '$name',
            'enabled' => true,
            'version' => '1.0.0',
        ];
        PHP;

        File::put("{$path}/Config/{$lower}.php", trim($content));
    }

    protected function createAssets($path, $name)
    {
        // Vendor publish garne tarika ra purano ko thau ma naya replace hunxa **php artisan vendor:publish --tag=kms-assets --force
        File::put("$path/Resources/assets/css/style.css", "/* {$name} module CSS */");
        File::put("$path/Resources/assets/js/app.js", "// {$name} module JS");
    }

    protected function createEnum($path, $name)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\$name\Enums;

        enum StatusEnum: string
        {
            case Draft = 'draft';
            case Sent = 'sent';
            case Accepted = 'accepted';
            case Rejected = 'rejected';
            case Expired = 'expired';

            public function label(): string
            {
                return match(\$this) {
                    self::Draft => 'Draft',
                    self::Sent => 'Sent',
                    self::Accepted => 'Accepted',
                    self::Rejected => 'Rejected',
                    self::Expired => 'Expired',
                };
            }

            public static function list(): array
            {
                return array_map(fn(\$status) => [
                    'id' => \$status->value,
                    'name' => \$status->label()
                ], self::cases());
            }
        }
        PHP;

        File::put("$path/Enums/StatusEnum.php", trim($content));
    }

    protected function createUploadPaths($path, $name)
    {
        $lowerName = strtolower($name);
        $content = <<<PHP
        <?php

        namespace App\Modules\\$name\Constants;

        class UploadPaths
        {
            public const PATHS = [
                'THUMBNAIL' => [
                    'path' => 'uploads/{$lowerName}/thumbnails',
                    'prefix' => 'thumb',
                ],
                'DOCUMENTS' => [
                    'path' => 'uploads/{$lowerName}/documents',
                    'prefix' => 'doc',
                ],
            ];
        }
        PHP;

        File::put("$path/Constants/UploadPaths.php", trim($content));
    }

    protected function getViewAlias(string $name): string
    {
        return strtolower($name);
    }
}
