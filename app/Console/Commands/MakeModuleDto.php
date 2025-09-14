<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleDto extends Command
{
    // php artisan module:make-dto TravelManagement HomeStayDto
    protected $signature = 'module:make-dto {module} {dtoPath}';
    protected $description = 'Create a new DTO file inside the specified module with optional subfolder path';

    public function handle(): void
    {
        $module = ucfirst($this->argument('module'));
        $dtoPath = $this->argument('dtoPath');

        // Clean path
        $dtoPath = str_replace('\\', '/', $dtoPath);
        $dtoParts = explode('/', $dtoPath);
        $dtoName = array_pop($dtoParts); // Get final file name

        $baseDir = app_path("Modules/{$module}/DTOs");
        $fullDir = $baseDir . '/' . implode('/', $dtoParts);
        $namespace = "App\\Modules\\{$module}\\DTOs" . (!empty($dtoParts) ? '\\' . implode('\\', $dtoParts) : '');

        if (!File::exists($fullDir)) {
            File::makeDirectory($fullDir, 0755, true);
        }

        $classContent = <<<PHP
        <?php

        declare(strict_types=1);

        namespace {$namespace};

        use App\Core\DTOs\BaseDto;
        use App\Core\Traits\MapForTable;
        use App\Core\Traits\SelectOptionTransformable;
        use App\Core\Traits\TableTransformable;

        class {$dtoName} extends BaseDto
        {
            use TableTransformable;
            use SelectOptionTransformable;
            use MapForTable;

            public function __construct(array \$attributes = [])
            {
                parent::__construct(\$attributes);
            }
        }
        PHP;

        $filePath = "{$fullDir}/{$dtoName}.php";
        if (File::exists($filePath)) {
            $this->error("DTO {$dtoName} already exists at: {$filePath}");
            return;
        }

        File::put($filePath, $classContent);
        $this->info("DTO {$dtoName} created successfully in module {$module}.");
    }
}
