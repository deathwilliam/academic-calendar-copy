<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de Editor
 * 
 * Permite acceso a usuarios con rol 'admin' o 'editor'.
 * Los editores pueden crear y modificar eventos, pero no eliminarlos ni publicarlos.
 * 
 * Uso: Route::middleware(['auth', 'editor'])->group(...)
 */
class EditorMiddleware
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
        // Verificar que el usuario esté autenticado Y sea admin o editor
        if (auth()->check() && in_array(auth()->user()->role, ['administrador', 'editor'])) {
            return $next($request); // Permitir acceso
        }

        // Denegar acceso si no tiene permisos de editor
        abort(403, 'Acción no autorizada. Se requiere acceso de editor o administrador.');
    }
}
