<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeModuleEnum extends Command
{
    // Usage: php artisan make:module-enum Post StatusEnum
    protected $signature = 'make:module-enum {module} {name}';
    protected $description = 'Create a new Enum inside a specific module';

    public function handle()
    {
        $module = ucfirst($this->argument('module'));
        $name = ucfirst($this->argument('name'));
        $path = app_path("Modules/{$module}/Enums");

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $content = "<?php

            namespace App\Modules\\{$module}\Enums;

            enum {$name}: string
            {
                case Example = 'example';

                public function label(): string
                {
                    return match (\$this) {
                        self::Example => 'Example',
                    };
                }

                public static function list(): array
                {
                    return array_map(
                        fn(\$item) => ['id' => \$item->value, 'name' => \$item->label()],
                        self::cases()
                    );
                }
            }
            ";

        File::put("{$path}/{$name}.php", $content);

        $this->info("Enum {$name} created in module {$module}.");
    }
}
