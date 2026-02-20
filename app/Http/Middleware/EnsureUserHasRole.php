<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        if (!$user || !$this->userHasRole($user, $role)) {
            abort(403, 'You are not authorized to access this page.');
        }

        return $next($request);
    }

    private function userHasRole(object $user, string $role): bool
    {
        if (method_exists($user, 'hasRole')) {
            return (bool) $user->hasRole($role);
        }

        return isset($user->role) && $user->role === $role;
    }
}
