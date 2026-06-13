<?php

namespace App\Http\Middleware;

use app\Enums\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (auth()->user()?->role !== UserRole::ADMIN) {
            abort(403);
        }

        return $next($request);
    }
}
