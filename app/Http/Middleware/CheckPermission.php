<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Core\Services\Implementation\AccessService;


class CheckPermission
{
    protected $accessService;

    public function __construct(AccessService $accessService)
    {
        $this->accessService = $accessService;
    }

    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        $action = Route::currentRouteAction();

        list($controller, $method) = explode('@', class_basename($action));

        // Service lai call gareko
        $hasPermission = $this->accessService->userHasPermission($user, $controller, $method);

        if (!$hasPermission) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}

