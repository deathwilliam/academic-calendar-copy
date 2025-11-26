<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de Auditor
 * 
 * Permite acceso a usuarios con rol 'admin', 'editor' o 'auditor'.
 * Los auditores pueden ver el historial de cambios pero no pueden modificar eventos.
 * 
 * Uso: Route::middleware(['auth', 'auditor'])->group(...)
 */
class AuditorMiddleware
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
        // Verificar que el usuario esté autenticado Y tenga algún rol de staff
        if (auth()->check() && in_array(auth()->user()->role, ['administrador', 'editor', 'auditor'])) {
            return $next($request); // Permitir acceso
        }

        // Denegar acceso si no tiene permisos de staff
        abort(403, 'Acción no autorizada. Se requiere acceso de personal autorizado.');
    }
}
