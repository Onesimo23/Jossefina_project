<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // O argumento $roles é a string passada na rota (ex: 'admin,coordinator')
    public function handle(Request $request, Closure $next, string $roles): Response
    {
        // 1. Verificar se o usuário está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // As roles esperadas vêm como uma string separada por vírgulas
        $rolesArray = explode(',', $roles);

        // 2. Verificar se a role do usuário está no array de roles permitidas
        if (in_array($user->role, $rolesArray)) {
            return $next($request);
        }

        // 3. Se o usuário não tem a role correta, nega o acesso.
        abort(403, 'Acesso não autorizado. Você não tem a função necessária para esta ação.');
    }
}
