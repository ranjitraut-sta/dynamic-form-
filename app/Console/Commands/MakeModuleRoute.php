<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleRoute extends Command
{
    protected $signature = 'module:make-route {module} {controller} {prefix?} {--res}';
    protected $description = 'Generate module routes: resource array entry (with --res) or full route group';

    public function handle()
    {
        $module = Str::studly($this->argument('module'));
        $controller = $this->argument('controller');
        $prefix = $this->argument('prefix') ?? $this->getRoutePrefix($controller);
        $useResourceArray = $this->option('res');

        $routeFilePath = base_path("app/Modules/{$module}/routes/web.php");
        $controllerClass = $this->formatControllerClass($controller, $module);

        if ($useResourceArray) {
            // Add commented resource array entry
            $this->updateResourceArray($routeFilePath, $prefix, $controllerClass);
            $this->info("✅ Resource entry added to resources array in {$routeFilePath}");
        } else {
            // Add full explicit route group with prefix and routes
            $this->updateFullRouteGroup($routeFilePath, $prefix, $controllerClass);
            $this->info("✅ Full route group added to {$routeFilePath}");
        }
    }

    protected function getRoutePrefix(string $controller): string
    {
        $base = preg_replace('/Controller$/', '', $controller);
        return Str::kebab($base);
    }

    protected function formatControllerClass(string $controller, string $module): string
    {
        if (str_contains($controller, '\\')) {
            return $controller;
        }

        return "App\\Modules\\{$module}\\Controllers\\{$controller}";
    }

    protected function updateResourceArray(string $filePath, string $routeName, string $controllerClass): void
    {
        if (!File::exists($filePath)) {
            $baseContent = <<<PHP
            <?php

            use Illuminate\Support\Facades\Route;

            Route::middleware(['web', 'auth'])->group(function () {
                \$resources = [
                    '{$routeName}' => {$controllerClass}::class,
                ];

                foreach (\$resources as \$route => \$controller) {
                    Route::resource(\$route, \$controller);
                }
            });

            PHP;
            File::put($filePath, $baseContent);
            return;
        }

        $content = File::get($filePath);

        // Prepare the new line with proper indentation and comma
        $line = "        '{$routeName}' => {$controllerClass}::class,";

        // Check if the line already exists
        if (strpos($content, $line) === false) {
            // Regex to find the resources array inside the file
            $pattern = '/(\$resources\s*=\s*\[)(.*?)(\];)/s';

            if (preg_match($pattern, $content, $matches)) {
                $resourcesContent = rtrim($matches[2]);

                // Remove trailing commas/spaces/newlines from existing content
                $resourcesContent = preg_replace('/,\s*$/', '', $resourcesContent);

                // Append the new line with newline and proper indentation
                $newResourcesContent = $resourcesContent ? $resourcesContent . ",\n" . $line . "\n    " : "\n" . $line . "\n    ";

                // Replace the old resources array content with the new one, keeping brackets intact
                $newContent = preg_replace($pattern, '$1' . $newResourcesContent . '$3', $content);

                File::put($filePath, $newContent);
            } else {
                // If no resources array found, fallback to add entire block cleanly
                $newContent = preg_replace(
                    '/(<\?php\s*)/',
                    "$0\n\nRoute::middleware(['web', 'auth'])->group(function () {\n    \$resources = [\n" . $line . "\n    ];\n\n    foreach (\$resources as \$route => \$controller) {\n        Route::resource(\$route, \$controller);\n    }\n});\n",
                    $content
                );

                File::put($filePath, $newContent);
            }
        }
    }


    protected function updateFullRouteGroup(string $filePath, string $prefix, string $controllerClass): void
    {
        $shortController = class_basename($controllerClass);
        $routeGroup = <<<PHP

        Route::middleware(['web', 'auth'])->prefix('{$prefix}')->name('{$prefix}.')->controller({$shortController}::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('store', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::get('show/{id}', 'show')->name('show');
            Route::put('update/{id}', 'update')->name('update');
            Route::delete('destroy/{id}', 'destroy')->name('destroy');
        });

        PHP;

        if (!File::exists($filePath)) {
            // Create new route file with PHP tag and use statement for Route and controller namespace
            $useNamespace = "use {$controllerClass};\n\n";
            $content = "<?php\n\nuse Illuminate\Support\Facades\Route;\n{$useNamespace}{$routeGroup}";
            File::put($filePath, $content);
            return;
        }

        $content = File::get($filePath);

        // Avoid duplicate route group
        if (strpos($content, $routeGroup) === false) {
            // Add use statement if missing
            if (!str_contains($content, "use {$controllerClass};")) {
                $content = preg_replace(
                    '/(<\?php\s*)/',
                    "$0\nuse {$controllerClass};",
                    $content,
                    1
                );
            }

            $content .= $routeGroup;
            File::put($filePath, $content);
        }
    }
}
