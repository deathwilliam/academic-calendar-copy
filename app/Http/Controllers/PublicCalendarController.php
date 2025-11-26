<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * Controlador del Calendario Público
 * 
 * Maneja la visualización del calendario público y la exportación a PDF.
 * No requiere autenticación - accesible para todos los usuarios.
 */
class PublicCalendarController extends Controller
{
    /**
     * Mostrar el calendario público con búsqueda y filtros
     * 
     * Muestra solo los eventos que han sido publicados.
     * Soporta búsqueda por texto y filtros por tipo y fecha.
     * Esta vista es accesible sin necesidad de iniciar sesión.
     * 
     * @param Request $request Parámetros de búsqueda y filtros
     * @return Response Vista Inertia del calendario público
     */
    public function index(Request $request): Response
    {
        // Iniciar query con eventos publicados
        $query = Event::where('is_published', true);

        // Búsqueda por texto en título o descripción
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filtro por tipo de evento
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filtro por rango de fechas
        if ($request->filled('start_date')) {
            $query->where('start_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('end_date', '<=', $request->end_date);
        }

        // Obtener eventos ordenados por fecha de inicio
        $events = $query->orderBy('start_date')->get();

        return Inertia::render('Public/Calendar', [
            'events' => $events,
            'filters' => [
                'search' => $request->search,
                'type' => $request->type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ],
        ]);
    }

    /**
     * Exportar el calendario a PDF
     * 
     * Genera un documento PDF con todos los eventos publicados.
     * El PDF incluye título, descripción, fechas y tipo de cada evento.
     * 
     * @return \Illuminate\Http\Response Descarga del archivo PDF
     */
    public function exportPdf()
    {
        // Obtener todos los eventos publicados
        $events = Event::where('is_published', true)
            ->orderBy('start_date')
            ->get();

        // Generar el PDF usando la vista blade
        $pdf = Pdf::loadView('pdf.calendar', ['events' => $events]);

        // Descargar el PDF directamente
        return $pdf->download('calendario-academico.pdf');
    }
}
