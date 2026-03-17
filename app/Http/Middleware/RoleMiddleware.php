<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        \Illuminate\Support\Facades\Log::info('Role Check:', [
            'user_email' => auth()->user()->email,
            'user_role' => auth()->user()->role,
            'required_roles' => $roles,
            'match' => in_array(auth()->user()->role, $roles)
        ]);

        if (auth()->user()->hasRole(...$roles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized action. You do not have the required role.');
    }
}
