<?php

namespace App\Core\Http;

use App\Modules\UserManagement\Models\Permission;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ReflectionClass;

class ControllerInspectorController extends BaseController
{

    // Example URL: http://127.0.0.1:8000/DesignationController/get

    public function getControllerMethods($controller)
    {
        $controllerName = Str::finish($controller, 'Controller');
        $basePath = app_path('Modules'); // app/Modules vitra khojna

        $controllerFile = collect(File::allFiles($basePath))
            ->first(function ($file) use ($controllerName) {
                return Str::endsWith($file->getFilename(), $controllerName . '.php');
            });

        if (!$controllerFile) {
            return response()->json(['error' => 'Controller not found'], 404);
        }

        // Namespace generate garne
        $relativePath = Str::replaceFirst(app_path(), '', $controllerFile->getPathname());
        $class = 'App' . str_replace(['/', '\\', '.php'], ['\\', '\\', ''], $relativePath);

        // Ensure file loaded (optional, but safer)
        require_once $controllerFile->getRealPath();

        try {
            if (!class_exists($class)) {
                return response()->json(['error' => 'Class not found: ' . $class], 404);
            }

            $reflection = new ReflectionClass($class);
            $methods = collect($reflection->getMethods(\ReflectionMethod::IS_PUBLIC))
                ->filter(fn($method) => $method->class === $class && !$method->isConstructor())
                ->pluck('name');

            // Permission table ma insert
            $inserted = [];
            foreach ($methods as $method) {
                $permission = [
                    'name' => Str::headline($method),
                    'action' => $method,
                    'controller' => class_basename($class),
                    'group_name' => Str::headline(Str::replaceLast('Controller', '', class_basename($class))),
                ];

                // Check if exists
                $exists = Permission::where('action', $method)
                    ->where('controller', class_basename($class))
                    ->exists();

                if (!$exists) {
                    Permission::create($permission);
                    $inserted[] = $permission;
                }
            }

            return response()->json([
                'controller' => $class,
                'methods' => $methods->values(),
                'inserted_permissions' => $inserted,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
