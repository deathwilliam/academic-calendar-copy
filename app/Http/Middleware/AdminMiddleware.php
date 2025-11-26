<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de Administrador
 * 
 * Verifica que el usuario autenticado tenga el rol de 'admin'.
 * Si no es administrador, retorna un error 403 (Prohibido).
 * 
 * Uso: Route::middleware(['auth', 'admin'])->group(...)
 */
class AdminMiddleware
{
    /**
     * Manejar una solicitud entrante
     * 
     * @param Request $request Solicitud HTTP
     * @param Closure $next Siguiente middleware en la cadena
     * @return Response Respuesta HTTP
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar que el usuario esté autenticado Y sea administrador
        if (auth()->check() && auth()->user()->role === 'administrador') {
            return $next($request); // Permitir acceso
        }

        // Denegar acceso si no es administrador
        abort(403, 'Acción no autorizada. Se requiere acceso de administrador.');
    }
}
