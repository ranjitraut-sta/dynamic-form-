<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleController extends Command
{
    // php artisan module:make-controller Post Sample
    protected $signature = 'module:make-controller {module} {name}';
    protected $description = 'Create a controller file inside a module';

    public function handle()
    {
        $module = ucfirst($this->argument('module'));
        $name = ucfirst($this->argument('name'));

        $controllerPath = app_path("Modules/{$module}/Controllers/{$name}Controller.php");

        if (File::exists($controllerPath)) {
            $this->error("Controller already exists!");
            return;
        }

        $namespace = "App\\Modules\\{$module}\\Controllers";

        $stub = <<<EOT
        <?php

        namespace {$namespace};

        use App\Http\Controllers\Controller;
        use Illuminate\Http\Request;

        class {$name}Controller extends Controller
        {
            public function index()
            {
                return response()->json(['message' => '{$name}Controller index']);
            }
        }
        EOT;

        File::put($controllerPath, $stub);

        $this->info("Controller {$name}Controller created in module {$module}.");
    }
}
