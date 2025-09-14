<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeCrud extends Command
{
    protected $signature = 'module:make-crud {module} {entity} {--remove : Remove the generated CRUD files}';
    protected $description = 'Generate complete CRUD files for a module entity';

    public function handle()
    {
        $module = Str::studly($this->argument('module'));
        $entity = Str::studly($this->argument('entity'));
        $entityLower = strtolower($entity);
        $entityPlural = Str::plural($entityLower);
        $entitySnake = Str::snake($entity);
        $entitySnakePlural = Str::snake(Str::plural($entity));

        $basePath = app_path("Modules/{$module}");

        // Check if module exists
        if (!File::exists($basePath)) {
            $this->error("Module '{$module}' does not exist. Please create the module first.");
            return;
        }

        // Handle remove option
        if ($this->option('remove')) {
            return $this->removeCrudFiles($basePath, $module, $entity, $entityLower, $entitySnakePlural);
        }

        // Create necessary directories
        $this->createDirectories($basePath);

        // Generate files
        $this->createController($basePath, $module, $entity, $entityLower);
        $this->createServiceInterface($basePath, $module, $entity);
        $this->createServiceImplementation($basePath, $module, $entity);
        $this->createRepositoryInterface($basePath, $module, $entity);
        $this->createRepositoryImplementation($basePath, $module, $entity, $entitySnake);
        $this->createRequest($basePath, $module, $entity);
        $this->createDto($basePath, $module, $entity);
        $this->createModel($basePath, $module, $entity, $entitySnake);
        $this->createMigration($basePath, $entity, $entitySnakePlural);
        $this->createViews($basePath, $module, $entity, $entityLower);
        $this->createRoutes($basePath, $module, $entity, $entityLower);
        $this->updateServiceProvider($basePath, $module, $entity);

        $this->info("✅ CRUD files for '{$entity}' created successfully in module '{$module}'");
        $this->info("📝 Don't forget to:");
        $this->info("   - Run migrations: php artisan module:migrate {$module}");
        $this->info("   - Update navigation menu");
    }

    protected function removeCrudFiles($basePath, $module, $entity, $entityLower, $entitySnakePlural)
    {
        if (!$this->confirm("Are you sure you want to remove all CRUD files for '{$entity}' in module '{$module}'?")) {
            $this->info('Operation cancelled.');
            return;
        }

        $filesToRemove = [
            "{$basePath}/Controllers/{$entity}Controller.php",
            "{$basePath}/Services/Interfaces/{$entity}ServiceInterface.php",
            "{$basePath}/Services/Implementations/{$entity}Service.php",
            "{$basePath}/Repositories/Interfaces/{$entity}RepositoryInterface.php",
            "{$basePath}/Repositories/Implementations/{$entity}Repository.php",
            "{$basePath}/Requests/{$entity}Request.php",
            "{$basePath}/DTOs/{$entity}/{$entity}Dto.php",
            "{$basePath}/Models/{$entity}.php",
        ];

        $removedCount = 0;
        foreach ($filesToRemove as $file) {
            if (File::exists($file)) {
                File::delete($file);
                $removedCount++;
                $this->line("🗑️  Removed: " . basename($file));
            }
        }

        // Remove views directory
        $viewsPath = "{$basePath}/Resources/views/{$entityLower}";
        if (File::exists($viewsPath)) {
            File::deleteDirectory($viewsPath);
            $removedCount++;
            $this->line("🗑️  Removed: views/{$entityLower}/ directory");
        }

        // Remove migration files
        $migrationPath = "{$basePath}/Database/Migrations";
        if (File::exists($migrationPath)) {
            $migrationFiles = File::glob("{$migrationPath}/*_create_{$entitySnakePlural}_table.php");
            foreach ($migrationFiles as $migrationFile) {
                File::delete($migrationFile);
                $removedCount++;
                $this->line("🗑️  Removed: " . basename($migrationFile));
            }
        }

        // Remove routes from web.php
        $this->removeRoutesFromWebFile($basePath, $entity, $entityLower);

        // Remove from ServiceProvider
        $this->removeFromServiceProvider($basePath, $module, $entity);

        if ($removedCount > 0) {
            $this->info("✅ Successfully removed {$removedCount} CRUD files for '{$entity}' from module '{$module}'");
            $this->warn("⚠️  Don't forget to:");
            $this->warn("   - Remove routes from navigation menu");
            $this->warn("   - Run migration rollback if needed");
        } else {
            $this->warn("No CRUD files found to remove for '{$entity}' in module '{$module}'");
        }
    }

    protected function createDirectories($basePath)
    {
        $directories = [
            'Controllers',
            'Services/Interfaces',
            'Services/Implementations',
            'Repositories/Interfaces',
            'Repositories/Implementations',
            'Requests',
            'DTOs',
            'Models',
            'Database/Migrations',
            'Resources/views',
            'Routes'
        ];

        foreach ($directories as $dir) {
            File::ensureDirectoryExists("{$basePath}/{$dir}");
        }
    }

    protected function createController($basePath, $module, $entity, $entityLower)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\{$module}\Controllers;

        use App\Core\Http\BaseCrudController;
        use App\Modules\\{$module}\DTOs\\{$entity}\\{$entity}Dto;
        use App\Modules\\{$module}\Requests\\{$entity}Request;
        use App\Modules\\{$module}\Services\Interfaces\\{$entity}ServiceInterface;
        use Illuminate\Http\Request;

        class {$entity}Controller extends BaseCrudController
        {
            protected string \$viewPrefix = "{$module}::{$entityLower}.";
            protected string \$routePrefix = '{$entityLower}.';
            protected string \$entityName = '{$entity}';
            protected string \$dtoClass = {$entity}Dto::class;

            public function __construct({$entity}ServiceInterface \$service)
            {
                \$this->service = \$service;
            }

            public function index(Request \$request)
            {
                \$perPage = \$request->input('length', 10);
                \$searchTerm = \$request->input('search');

                return \$this->dataIndex(\$perPage, \$searchTerm);
            }

            public function create()
            {
                return \$this->dataCreate();
            }

            public function store({$entity}Request \$request)
            {
                return \$this->dataStore(\$request);
            }

            public function show(\$id)
            {
                return \$this->dataShow(\$id);
            }

            public function edit(\$id)
            {
                return \$this->dataEdit(\$id);
            }

            public function update({$entity}Request \$request, \$id)
            {
                return \$this->dataUpdate(\$request, \$id);
            }

            public function destroy(\$id)
            {
                return \$this->dataDelete(\$id);
            }

            public function bulkDelete(Request \$request)
            {
                \$ids = \$request->input('ids', []);
                return \$this->dataDelete(\$ids);
            }

            public function updateOrder(Request \$request)
            {
                return \$this->updateOrderInternal(\$request, '{$entityLower}s', 'id', 'display_order');
            }
        }
        PHP;

        File::put("{$basePath}/Controllers/{$entity}Controller.php", $content);
    }

    protected function createServiceInterface($basePath, $module, $entity)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\{$module}\Services\Interfaces;
        use App\Core\Services\Interface\BaseServiceInterface;

        interface {$entity}ServiceInterface extends BaseServiceInterface
        {
            public function getPaginatedSearchResults(\$perPage, \$searchTerm);
        }
        PHP;

        File::put("{$basePath}/Services/Interfaces/{$entity}ServiceInterface.php", $content);
    }

    protected function createServiceImplementation($basePath, $module, $entity)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\{$module}\Services\Implementations;

        use App\Core\Services\Implementation\BaseService;
        use App\Modules\\{$module}\Services\Interfaces\\{$entity}ServiceInterface;
        use App\Modules\\{$module}\Repositories\Interfaces\\{$entity}RepositoryInterface;

        class {$entity}Service extends BaseService implements {$entity}ServiceInterface
        {
            public function __construct({$entity}RepositoryInterface \$repository)
            {
                parent::__construct(\$repository);
            }

            public function getPaginatedSearchResults(\$perPage, \$searchTerm)
            {
                return \$this->repository->getPaginatedSearchResults(\$perPage, \$searchTerm);
            }
        }
        PHP;

        File::put("{$basePath}/Services/Implementations/{$entity}Service.php", $content);
    }

    protected function createRepositoryInterface($basePath, $module, $entity)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\{$module}\Repositories\Interfaces;
        use App\Core\Repositories\Interface\BaseRepositoryInterface;

        interface {$entity}RepositoryInterface extends BaseRepositoryInterface
        {
            public function getPaginatedSearchResults(\$perPage, \$searchTerm);
        }
        PHP;

        File::put("{$basePath}/Repositories/Interfaces/{$entity}RepositoryInterface.php", $content);
    }

    protected function createRepositoryImplementation($basePath, $module, $entity, $entitySnake)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\{$module}\Repositories\Implementations;

        use App\Core\Repositories\Implementation\BaseRepository;
        use App\Modules\\{$module}\Repositories\Interfaces\\{$entity}RepositoryInterface;
        use App\Modules\\{$module}\Models\\{$entity};

        class {$entity}Repository extends BaseRepository implements {$entity}RepositoryInterface
        {
            public function __construct({$entity} \$model)
            {
                parent::__construct(\$model);
            }

            public function getPaginatedSearchResults(\$perPage, \$searchTerm)
            {
                \$query = \$this->model->query();

                if (\$searchTerm) {
                    \$query->where('name', 'LIKE', "%{\$searchTerm}%");
                }

                return \$query->orderBy('display_order')->paginate(\$perPage);
            }
        }
        PHP;

        File::put("{$basePath}/Repositories/Implementations/{$entity}Repository.php", $content);
    }

    protected function createRequest($basePath, $module, $entity)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\{$module}\Requests;

        use App\Core\Request\BaseFormRequest;

        class {$entity}Request extends BaseFormRequest
        {
            protected function getCreateRules(): array
            {
                return [
                    'name' => ['required', 'string', 'max:255'],
                    'status' => ['required', 'in:active,inactive'],
                    'display_order' => ['nullable', 'integer', 'min:1'],
                ];
            }

            protected function getUpdateRules(): array
            {
                return [
                    'name' => ['required', 'string', 'max:255'],
                    'status' => ['required', 'in:active,inactive'],
                    'display_order' => ['nullable', 'integer', 'min:1'],
                ];
            }

            protected function getMessages(): array
            {
                return [
                    'name.required' => 'The name field is required.',
                    'name.string' => 'The name must be a string.',
                    'name.max' => 'The name may not be greater than 255 characters.',
                    'status.required' => 'The status field is required.',
                    'status.in' => 'The status must be either active or inactive.',
                ];
            }
        }
        PHP;

        File::put("{$basePath}/Requests/{$entity}Request.php", $content);
    }

    protected function createDto($basePath, $module, $entity)
    {
        $entityLower = strtolower($entity);
        $dtoPath = "{$basePath}/DTOs/{$entity}";
        File::ensureDirectoryExists($dtoPath);

        $content = <<<PHP
        <?php

        declare(strict_types=1);

        namespace App\Modules\\{$module}\DTOs\\{$entity};

        use App\Core\DTOs\BaseDto;

        class {$entity}Dto extends BaseDto
        {
            public ?int \$id;
            public string \$name;
            public string \$status;
            public ?int \$display_order;

            public function getDataForTable(\$data): array
            {
                return [
                    'id' => \$this->id,
                    'name' => \$this->name,
                    'status' => \$this->status,
                    'display_order' => \$this->display_order
                ];
            }

            public function getDataForSelectOption(): array
            {
                return [
                    'id' => \$this->id,
                    'name' => \$this->name,
                ];
            }
        }
        PHP;

        File::put("{$dtoPath}/{$entity}Dto.php", $content);
    }

    protected function createModel($basePath, $module, $entity, $entitySnake)
    {
        $content = <<<PHP
        <?php

        namespace App\Modules\\{$module}\Models;

        use Illuminate\Database\Eloquent\Factories\HasFactory;
        use Illuminate\Database\Eloquent\Model;

        class {$entity} extends Model
        {
            use HasFactory;

            protected \$table = '{$entitySnake}s';

            protected \$fillable = [
                'name',
                'status',
                'display_order',
            ];
        }
        PHP;

        File::put("{$basePath}/Models/{$entity}.php", $content);
    }

    protected function createMigration($basePath, $entity, $entitySnakePlural)
    {
        $timestamp = now()->format('Y_m_d_His');
        $className = 'Create' . Str::studly($entitySnakePlural) . 'Table';

        $content = <<<PHP
        <?php

        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        return new class extends Migration
        {
            public function up()
            {
                Schema::create('{$entitySnakePlural}', function (Blueprint \$table) {
                    \$table->id();
                    \$table->string('name');
                    \$table->enum('status', ['active', 'inactive'])->default('active');
                    \$table->integer('display_order')->nullable();
                    \$table->timestamps();
                });
            }

            public function down()
            {
                Schema::dropIfExists('{$entitySnakePlural}');
            }
        };
        PHP;

        File::put("{$basePath}/Database/Migrations/{$timestamp}_create_{$entitySnakePlural}_table.php", $content);
    }

    protected function createViews($basePath, $module, $entity, $entityLower)
    {
        $viewPath = "{$basePath}/Resources/views/{$entityLower}";
        File::ensureDirectoryExists($viewPath);
        File::ensureDirectoryExists("{$viewPath}/partial");

        // Index view
        $indexContent = <<<BLADE
        @extends('admin.main.app')
        @section('content')

            {{-- Breadcrumb --}}
            <x-ui.breadcrumb :title="'{$entity}s'" :items="[
                ['label' => '{$entity} List', 'url' => route('{$entityLower}.index')],
                ['label' => '{$entity} Index', 'url' => '', 'active' => true],
            ]" />

            <div class="card shadow-sm border-0">
                {{-- Header Section --}}
                <x-table.top-header :title="'{$entity} List'" :createRoute="route('{$entityLower}.create')" :createLabel="'Add New'" />

                <div class="card-body">
                    <!-- Bulk Actions will be dynamically created by JS -->

                    <!-- Table -->
                    <div class="amd-soft-table-wrapper bulk-enabled" data-bulk-delete-url="{{ route('{$entityLower}.bulk-delete') }}">
                        {{-- Filter --}}
                        <x-table.filter :action="route('{$entityLower}.index')" :placeholder="'Search {$entity}s'" />

                        <table class="amd-soft-table" role="grid" aria-describedby="table-description">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="select-all" class="form-check-input amd-colored-check primary">
                                    </th>
                                    <th>S.N.</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="sortable-table" data-sort-url="{{ route('{$entityLower}.order') }}">
                                @foreach (\$data['records'] as \$item)
                                    <tr data-id="{{ \$item['id'] }}" data-display-order="{{ \$item['display_order'] ?? '' }}">
                                        <td>
                                            <input type="checkbox" class="row-select form-check-input amd-colored-check primary" value="{{ \$item['id'] }}">
                                        </td>
                                        <td>{{ (\$data['records']->currentPage() - 1) * \$data['records']->perPage() + \$loop->iteration }}</td>
                                        <td>{{ \$item['name'] }}</td>
                                        <td>
                                            <x-table.status-badge :status="\$item['status']" />
                                        </td>
                                        <td name="bstable-actions">
                                            <div class="btn-group pull-right">
                                                <x-table.edit-button :id="\$item['id']" :route="'{$entityLower}.edit'" />
                                                <x-table.delete-button :id="\$item['id']" :route="'{$entityLower}.destroy'" />
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- Pagination --}}
                        <x-table.pagination :records="\$data['records']" />
                    </div>
                </div>
            </div>

        @endsection
        BLADE;

        File::put("{$viewPath}/index.blade.php", $indexContent);

        // Create view
        $createContent = <<<BLADE
        @extends('admin.main.app')
        @include('alert.top-end')
        @section('content')
            {{-- Breadcrumb --}}
            <x-ui.breadcrumb :title="'{$entity}s'" :items="[
                ['label' => isset(\$data['record']->id) ? 'Edit {$entity}' : 'Create {$entity}', 'url' => route('{$entityLower}.index')],
                ['label' => isset(\$data['record']->id) ? 'Edit {$entity}' : 'Create {$entity}', 'url' => '', 'active' => true],
            ]" />
            <div class="card">
                {{-- Page Header --}}
                <x-ui.page-header :backRoute="route('{$entityLower}.index')" :title="isset(\$data['record']->id) ? 'Edit {$entity}' : 'Create {$entity}'" />

                {{-- Form Section --}}
                <div class="card-body">
                    <div class="p-4 border rounded">
                        @include('{$module}::{$entityLower}.partial._form')
                    </div>
                </div>
            </div>

        @endsection
        BLADE;

        File::put("{$viewPath}/create.blade.php", $createContent);

        // Show view
        $showContent = <<<BLADE
        @extends('admin.main.app')
        @section('content')
            {{-- Breadcrumb --}}
            <x-ui.breadcrumb :title="'{$entity}s'" :items="[
                ['label' => '{$entity} List', 'url' => route('{$entityLower}.index')],
                ['label' => 'View {$entity}', 'url' => '', 'active' => true],
            ]" />

            <div class="card">
                {{-- Page Header --}}
                <x-ui.page-header :backRoute="route('{$entityLower}.index')" :title="'View {$entity}'" />

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>Name:</h5>
                            <p>{{ \$data['record']->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Status:</h5>
                            <x-table.status-badge :status="\$data['record']->status" />
                        </div>
                    </div>
                </div>
            </div>

        @endsection
        BLADE;

        File::put("{$viewPath}/show.blade.php", $showContent);

        // Form partial
        $formContent = <<<BLADE
        <form action="{{ isset(\$data['record']->id) ? route('{$entityLower}.update', \$data['record']->id) : route('{$entityLower}.store') }}" method="POST">
            @csrf
            @if(isset(\$data['record']->id))
                @method('PUT')
            @endif

            <div class="row">
                <div class="col-md-6">
                    <x-form.text-input
                        name="name"
                        label="Name"
                        :value="old('name', \$data['record']->name ?? '')"
                        required
                    />
                </div>

                <div class="col-md-6">
                    <x-form.select-input
                        name="status"
                        label="Status"
                        :options="[
                            'active' => 'Active',
                            'inactive' => 'Inactive'
                        ]"
                        :value="old('status', \$data['record']->status ?? 'active')"
                        required
                    />
                </div>

                <div class="col-md-6">
                    <x-form.number-input
                        name="display_order"
                        label="Display Order"
                        :value="old('display_order', \$data['record']->display_order ?? '')"
                    />
                </div>
            </div>

            <div class="mt-4">
                <x-form.submit-button :text="isset(\$data['record']->id) ? 'Update {$entity}' : 'Create {$entity}'" />
                <a href="{{ route('{$entityLower}.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
        BLADE;

        File::put("{$viewPath}/partial/_form.blade.php", $formContent);
    }

    protected function createRoutes($basePath, $module, $entity, $entityLower)
    {
        $webRoutesPath = "{$basePath}/Routes/web.php";

        // Create routes content for this entity
        $routesContent = <<<PHP
            //---------------------------{$entity} SECTION ROUTE-----------------------------
            Route::prefix('{$entityLower}')->as('{$entityLower}.')->controller({$entity}Controller::class)->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('create', 'create')->name('create');
                Route::post('store', 'store')->name('store');
                Route::get('edit/{id}', 'edit')->name('edit');
                Route::get('show/{id}', 'show')->name('show');
                Route::put('update/{id}', 'update')->name('update');
                Route::delete('destroy/{id}', 'destroy')->name('destroy');
                Route::delete('bulk-delete', 'bulkDelete')->name('bulk-delete');
                Route::post('update-order', 'updateOrder')->name('order');
            });
        PHP;

        // Check if web.php exists
        if (File::exists($webRoutesPath)) {
            $existingContent = File::get($webRoutesPath);

            // Add use statement if not exists
            $useStatement = "use App\\Modules\\{$module}\\Controllers\\{$entity}Controller;";
            if (strpos($existingContent, $useStatement) === false) {
                // Find the last use statement and add after it
                $existingContent = preg_replace(
                    '/(use [^;]+;\n)(?!use)/s',
                    "$1{$useStatement}\n",
                    $existingContent,
                    1
                );
            }

            // Try to add routes before ROLE HAS PERMISSION comment first
            if (strpos($existingContent, '//---------------------------ROLE HAS PERMISSION') !== false) {
                $existingContent = preg_replace(
                    '/(\s*)(\}\);\s*\/\/---------------------------ROLE HAS PERMISSION)/s',
                    "$1{$routesContent}\n$1$2",
                    $existingContent
                );
            } else {
                // For new modules, add before the closing brace
                $existingContent = preg_replace(
                    '/(\s*\/\/ Module routes will be added here\s*\n)(\s*\}\);)/s',
                    "$1{$routesContent}\n$2",
                    $existingContent
                );
            }

            File::put($webRoutesPath, $existingContent);
        } else {
            // Create new web.php file with basic structure
            $fullContent = <<<PHP
            <?php

            use App\Modules\\{$module}\Controllers\\{$entity}Controller;
            use Illuminate\Support\Facades\Route;

            Route::prefix('admin')->middleware(['web', 'auth'])->group(function () {
            {$routesContent}
            });
            PHP;
            File::put($webRoutesPath, $fullContent);
        }
    }

    protected function updateServiceProvider($basePath, $module, $entity)
    {
        $providerPath = "{$basePath}/Providers/{$module}ServiceProvider.php";

        if (!File::exists($providerPath)) {
            $this->warn("ServiceProvider not found. Please add bindings manually.");
            return;
        }

        $content = File::get($providerPath);

        // Add use statements if not exists
        $useStatements = [
            "use App\\Modules\\{$module}\\Services\\Interfaces\\{$entity}ServiceInterface;",
            "use App\\Modules\\{$module}\\Services\\Implementations\\{$entity}Service;",
            "use App\\Modules\\{$module}\\Repositories\\Interfaces\\{$entity}RepositoryInterface;",
            "use App\\Modules\\{$module}\\Repositories\\Implementations\\{$entity}Repository;"
        ];

        foreach ($useStatements as $useStatement) {
            if (strpos($content, $useStatement) === false) {
                // Find the last use statement and add after it
                $content = preg_replace(
                    '/(use [^;]+;\n)(?!use)/s',
                    "$1{$useStatement}\n",
                    $content,
                    1
                );
            }
        }

        // Add service bindings in register method
        $serviceBinding = "        \$this->app->bind({$entity}ServiceInterface::class, {$entity}Service::class);";
        $repositoryBinding = "        \$this->app->bind({$entity}RepositoryInterface::class, {$entity}Repository::class);";

        // Check if bindings already exist
        if (strpos($content, $serviceBinding) === false) {
            // Find register method and add bindings
            $registerPattern = '/(public function register\(\)\s*\{[^}]*)/s';
            if (preg_match($registerPattern, $content)) {
                $content = preg_replace(
                    $registerPattern,
                    "$1\n{$serviceBinding}\n{$repositoryBinding}\n",
                    $content
                );
            }
        }

        File::put($providerPath, $content);
        $this->line("✅ Updated ServiceProvider with {$entity} bindings");
    }

    protected function removeFromServiceProvider($basePath, $module, $entity)
    {
        $providerPath = "{$basePath}/Providers/{$module}ServiceProvider.php";

        if (!File::exists($providerPath)) {
            return;
        }

        $content = File::get($providerPath);

        // Remove use statements
        $useStatements = [
            "use App\\Modules\\{$module}\\Services\\Interfaces\\{$entity}ServiceInterface;",
            "use App\\Modules\\{$module}\\Services\\Implementations\\{$entity}Service;",
            "use App\\Modules\\{$module}\\Repositories\\Interfaces\\{$entity}RepositoryInterface;",
            "use App\\Modules\\{$module}\\Repositories\\Implementations\\{$entity}Repository;"
        ];

        foreach ($useStatements as $useStatement) {
            $content = str_replace($useStatement . "\n", '', $content);
        }

        // Remove service bindings
        $serviceBinding = "        \$this->app->bind({$entity}ServiceInterface::class, {$entity}Service::class);";
        $repositoryBinding = "        \$this->app->bind({$entity}RepositoryInterface::class, {$entity}Repository::class);";

        $content = str_replace($serviceBinding . "\n", '', $content);
        $content = str_replace($repositoryBinding . "\n", '', $content);

        File::put($providerPath, $content);
        $this->line("✅ Removed {$entity} bindings from ServiceProvider");
    }

    protected function removeRoutesFromWebFile($basePath, $entity, $entityLower)
    {
        $webRoutesPath = "{$basePath}/Routes/web.php";

        if (!File::exists($webRoutesPath)) {
            return;
        }

        $content = File::get($webRoutesPath);

        // Remove use statement
        $useStatement = "use App\\Modules\\UserManagement\\Controllers\\{$entity}Controller;";
        $content = str_replace($useStatement . "\n", '', $content);

        // Remove the entire routes block for this entity
        $routesPattern = "/\s*\/\/---------------------------{$entity} SECTION ROUTE-----------------------------.*?\n\s*\}\);/s";
        $content = preg_replace($routesPattern, '', $content);

        // Clean up empty lines
        $content = preg_replace('/\n\s*\n\s*\n/', "\n\n", $content);

        File::put($webRoutesPath, $content);
        $this->line("🗑️  Removed {$entity} routes from web.php");
    }
}
