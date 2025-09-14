<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleRequest extends Command
{
    // php artisan make:module-request ModuleName Subfolder/FileName
    protected $signature = 'make:module-request {module} {name}';
    protected $description = 'Create a new form request inside a module';

    public function handle()
    {
        $module = ucfirst($this->argument('module'));
        $nameInput = str_replace('\\', '/', $this->argument('name'));

        $parts = explode('/', $nameInput);
        $className = array_pop($parts);
        $subfolder = implode('/', $parts);

        $namespacePart = implode('\\', $parts);
        $baseNamespace = "App\\Modules\\{$module}\\Requests" . ($namespacePart ? "\\$namespacePart" : '');
        $directory = app_path("Modules/{$module}/Requests/" . $subfolder);

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $content = <<<PHP
        <?php

        namespace {$baseNamespace};

        use Illuminate\Foundation\Http\FormRequest;

        class {$className} extends FormRequest
        {
            public function authorize(): bool
            {
                return true;
            }

            public function rules(): array
            {
                return [
                    // 'field' => 'required|string|max:255',
                ];
            }
        }
        PHP;

        $filePath = "{$directory}/{$className}.php";
        File::put($filePath, $content);

        $this->info("Request class {$className} created in module {$module} at {$filePath}");
    }
}
