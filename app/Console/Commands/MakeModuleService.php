<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleService extends Command
{
    protected $signature = 'make:module-service {module} {name} {--remove}';
    protected $description = 'Create or remove service, repository, and controller for a given module.';

    public function handle()
    {
        $module = Str::studly($this->argument('module'));
        $name = Str::studly($this->argument('name'));
        $remove = $this->option('remove');

        $basePath = app_path("Modules/{$module}");

        if ($remove) {
            $this->removeFiles($basePath, $name);
            $this->removeBindings($module, $name);
            $this->info("🗑️  {$name}Service, Repository & Controller removed from module {$module}.");
        } else {
            File::ensureDirectoryExists("{$basePath}/Controllers");
            File::ensureDirectoryExists("{$basePath}/Services/Interfaces");
            File::ensureDirectoryExists("{$basePath}/Services/Implementations");
            File::ensureDirectoryExists("{$basePath}/Repositories/Interfaces");
            File::ensureDirectoryExists("{$basePath}/Repositories/Implementations");

            $this->createController($basePath, $module, $name);
            $this->createServiceInterface($basePath, $module, $name);
            $this->createServiceImpl($basePath, $module, $name);
            $this->createRepoInterface($basePath, $module, $name);
            $this->createRepoImpl($basePath, $module, $name);
            $this->updateServiceProvider($module, $name);

            $this->info("✅ {$name}Service, Repository & Controller created under module {$module}.");
        }
    }

    protected function createController($path, $module, $name)
    {
        $view = strtolower($name);

        $content = <<<PHP
        <?php

        namespace App\Modules\\$module\Controllers;

        use App\Http\Controllers\Controller;
        use Illuminate\Http\Request;
        use App\Modules\\$module\Services\Interfaces\\{$name}ServiceInterface;

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
                return view('{$view}::index', compact('data'));
            }
        }
        PHP;

        File::put("{$path}/Controllers/{$name}Controller.php", trim($content));
    }

    protected function createServiceInterface($path, $module, $name)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\$module\Services\Interfaces;

        use App\Core\Services\Interface\BaseServiceInterface;

        interface {$name}ServiceInterface extends BaseServiceInterface
        {
        }
        PHP;

        File::put("{$path}/Services/Interfaces/{$name}ServiceInterface.php", trim($content));
    }

    protected function createServiceImpl($path, $module, $name)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\$module\Services\Implementations;

        use App\Core\Services\Implementation\BaseService;
        use App\Modules\\$module\Services\Interfaces\\{$name}ServiceInterface;
        use App\Modules\\$module\Repositories\Interfaces\\{$name}RepositoryInterface;

        class {$name}Service extends BaseService implements {$name}ServiceInterface
        {
            public function __construct({$name}RepositoryInterface \$repository)
            {
                parent::__construct(\$repository);
            }
        }
        PHP;

        File::put("{$path}/Services/Implementations/{$name}Service.php", trim($content));
    }

    protected function createRepoInterface($path, $module, $name)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\$module\Repositories\Interfaces;

        use App\Core\Repositories\Interface\BaseRepositoryInterface;

        interface {$name}RepositoryInterface extends BaseRepositoryInterface
        {
        }
        PHP;

        File::put("{$path}/Repositories/Interfaces/{$name}RepositoryInterface.php", trim($content));
    }

    protected function createRepoImpl($path, $module, $name)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\$module\Repositories\Implementations;

        use App\Core\Repositories\Implementation\BaseRepository;
        use App\Modules\\$module\Repositories\Interfaces\\{$name}RepositoryInterface;

        class {$name}Repository extends BaseRepository implements {$name}RepositoryInterface
        {
            public function __construct(\$model)
            {
                parent::__construct(\$model);
            }
        }
        PHP;

        File::put("{$path}/Repositories/Implementations/{$name}Repository.php", trim($content));
    }

    protected function updateServiceProvider($module, $name)
    {
        $providerPath = app_path("Modules/{$module}/Providers/{$module}ServiceProvider.php");


        if (!File::exists($providerPath)) {
            $this->warn("⚠️  {$module}ServiceProvider not found. Skipping binding.");
            return;
        }

        $interfaceBinding = "\$this->app->bind(\\App\\Modules\\{$module}\\Repositories\\Interfaces\\{$name}RepositoryInterface::class, \\App\\Modules\\{$module}\\Repositories\\Implementations\\{$name}Repository::class);";
        $serviceBinding = "\$this->app->bind(\\App\\Modules\\{$module}\\Services\\Interfaces\\{$name}ServiceInterface::class, \\App\\Modules\\{$module}\\Services\\Implementations\\{$name}Service::class);";

        $providerContent = File::get($providerPath);

        if (!Str::contains($providerContent, $interfaceBinding)) {
            $providerContent = preg_replace(
                '/(public function register\(\)\s*\{\s*)/i',
                "\$1\n        {$interfaceBinding}\n        {$serviceBinding}\n",
                $providerContent
            );

            File::put($providerPath, $providerContent);
            $this->info("🔧 Bindings added to {$module}ServiceProvider.");
        } else {
            $this->info("ℹ️  Bindings already exist in {$module}ServiceProvider.");
        }
    }

    protected function removeFiles($basePath, $name)
    {
        $paths = [
            "{$basePath}/Controllers/{$name}Controller.php",
            "{$basePath}/Services/Interfaces/{$name}ServiceInterface.php",
            "{$basePath}/Services/Implementations/{$name}Service.php",
            "{$basePath}/Repositories/Interfaces/{$name}RepositoryInterface.php",
            "{$basePath}/Repositories/Implementations/{$name}Repository.php",
        ];

        foreach ($paths as $path) {
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }

    protected function removeBindings($module, $name)
    {
        $providerPath = app_path("Modules/{$module}/Providers/{$module}ServiceProvider.php");


        if (!File::exists($providerPath)) {
            $this->warn("⚠️  {$module}ServiceProvider not found. Skipping unbinding.");
            return;
        }

        $providerContent = File::get($providerPath);

        $bindings = [
            "\$this->app->bind(\\App\\Modules\\{$module}\\Repositories\\Interfaces\\{$name}RepositoryInterface::class, \\App\\Modules\\{$module}\\Repositories\\Implementations\\{$name}Repository::class);",
            "\$this->app->bind(\\App\\Modules\\{$module}\\Services\\Interfaces\\{$name}ServiceInterface::class, \\App\\Modules\\{$module}\\Services\\Implementations\\{$name}Service::class);"
        ];

        foreach ($bindings as $bind) {
            $providerContent = str_replace($bind . "\n", '', $providerContent);
        }

        File::put($providerPath, $providerContent);
        $this->info("🧹 Bindings removed from {$module}ServiceProvider.");
    }
}
