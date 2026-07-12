<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $roleName = optional($user->role)->nom;

        if ($roleName === 'Administrateur' || in_array($roleName, $roles, true)) {
            return $next($request);
        }

        abort(403, 'Vous n’êtes pas autorisé à accéder à cette section.');
    }
}
