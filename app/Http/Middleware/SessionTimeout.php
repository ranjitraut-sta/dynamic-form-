<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

class SessionTimeout
{
    protected $timeout; // seconds

    public function __construct()
    {
    // Laravel session lifetime is in minutes; convert to seconds
     $this->timeout = Config::get('session.lifetime', 120) * 60;
    }

    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $lastActivity = Session::get('last_activity_time');
            $now = now()->timestamp;

            if ($lastActivity && ($now - $lastActivity > $this->timeout)) {
                Auth::logout();
                Session::flush();

                return redirect()->route('login');
            }

            Session::put('last_activity_time', $now);
        }

        return $next($request);
    }
}
