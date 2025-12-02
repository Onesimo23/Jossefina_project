<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // O argumento $roles é a string passada na rota (ex: 'admin,coordinator')
    public function handle(Request $request, Closure $next, string $roles): Response {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Remove espaços em branco
        $rolesArray = array_map('trim', explode(',', $roles));

        if (in_array($user->role, $rolesArray)) {
            return $next($request);
        }

        abort(403, 'Acesso não autorizado.');
    }
}
