<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Controlador de Eventos
 * 
 * Maneja todas las operaciones CRUD para eventos académicos.
 * Incluye funcionalidad de auditoría y reversión de cambios.
 * 
 * Permisos por rol:
 * - Admin: Acceso completo (crear, editar, eliminar, publicar, revertir)
 * - Editor: Crear y editar eventos (no puede eliminar ni publicar)
 * - Auditor: Solo puede ver el historial de cambios
 */
class EventController extends Controller
{
    /**
     * Mostrar lista de todos los eventos
     * 
     * @return Response Vista Inertia con la lista de eventos
     */
    public function index(): Response
    {
        // Obtener todos los eventos con información del usuario creador
        $events = Event::with('user')
            ->latest() // Ordenar por más recientes primero
            ->get();

        return Inertia::render('Events/Index', [
            'events' => $events,
        ]);
    }

    /**
     * Mostrar formulario para crear nuevo evento
     * 
     * @return Response Vista Inertia del formulario de creación
     */
    public function create(): Response
    {
        return Inertia::render('Events/Create');
    }

    /**
     * Guardar un nuevo evento en la base de datos
     * 
     * Solo los administradores pueden publicar eventos al crearlos.
     * 
     * @param Request $request Datos del formulario
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista de eventos
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'title' => 'required|string|max:255', // Título obligatorio
            'description' => 'nullable|string', // Descripción opcional
            'start_date' => 'required|date', // Fecha de inicio obligatoria
            'end_date' => 'required|date|after_or_equal:start_date', // Fecha fin debe ser después del inicio
            'type' => 'required|string|in:general,exam,holiday,meeting,deadline', // Tipo de evento
            'is_published' => 'boolean', // Estado de publicación
        ]);

        // Solo los administradores pueden publicar eventos
        if (isset($validated['is_published']) && $validated['is_published'] === true) {
            if (auth()->user()->role !== 'administrador') {
                // Forzar a false si no es administrador
                $validated['is_published'] = false;
            }
        }

        // Crear el evento y asociarlo con el usuario actual
        $event = Event::create([
            ...$validated,
            'user_id' => auth()->id(), // Guardar quién creó el evento
        ]);

        return redirect()->route('events.index')
            ->with('success', 'Evento creado exitosamente.');
    }

    /**
     * Mostrar formulario para editar un evento existente
     * 
     * @param Event $event Evento a editar (inyección de modelo)
     * @return Response Vista Inertia del formulario de edición
     */
    public function edit(Event $event): Response
    {
        return Inertia::render('Events/Edit', [
            'event' => $event,
        ]);
    }

    /**
     * Actualizar un evento existente
     * 
     * Solo los administradores pueden cambiar el estado de publicación.
     * 
     * @param Request $request Datos actualizados
     * @param Event $event Evento a actualizar
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista
     */
    public function update(Request $request, Event $event)
    {
        // Validar los datos actualizados
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|string|in:general,exam,holiday,meeting,deadline',
            'is_published' => 'boolean',
        ]);

        // Verificar permiso para publicar/despublicar (solo admin)
        if (isset($validated['is_published']) && $validated['is_published'] != $event->is_published) {
            if (auth()->user()->role !== 'administrador') {
                abort(403, 'Solo los administradores pueden publicar o despublicar eventos.');
            }
        }

        // Actualizar el evento (se registrará automáticamente en auditoría)
        $event->update($validated);

        return redirect()->route('events.index')
            ->with('success', 'Evento actualizado exitosamente.');
    }

    /**
     * Eliminar un evento
     * 
     * Solo los administradores pueden eliminar eventos.
     * 
     * @param Event $event Evento a eliminar
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista
     */
    public function destroy(Event $event)
    {
        // Verificar que el usuario sea administrador
        if (auth()->user()->role !== 'administrador') {
            abort(403, 'Solo los administradores pueden eliminar eventos.');
        }

        // Eliminar el evento
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Evento eliminado exitosamente.');
    }

    /**
     * Mostrar historial de auditoría de un evento
     * 
     * Muestra todos los cambios realizados al evento con información
     * de quién hizo cada cambio y cuándo.
     * 
     * @param Event $event Evento del cual ver el historial
     * @return Response Vista Inertia con el historial de auditoría
     */
    public function audits(Event $event)
    {
        // Obtener todas las auditorías del evento con información del usuario
        $audits = $event->audits()
            ->with('user') // Incluir información de quién hizo el cambio
            ->latest() // Ordenar por más recientes primero
            ->get();

        return Inertia::render('Events/Audits', [
            'event' => $event,
            'audits' => $audits,
        ]);
    }

    /**
     * Revertir un evento a una versión anterior
     * 
     * Solo los administradores pueden revertir cambios.
     * Restaura el evento a los valores que tenía en un punto específico del historial.
     * 
     * @param Event $event Evento a revertir
     * @param int $auditId ID de la auditoría a la cual revertir
     * @return \Illuminate\Http\RedirectResponse Redirección a la lista
     */
    public function revert(Event $event, $auditId)
    {
        // Verificar que el usuario sea administrador
        if (auth()->user()->role !== 'administrador') {
            abort(403, 'Solo los administradores pueden revertir eventos.');
        }

        // Buscar la auditoría específica
        $audit = $event->audits()->findOrFail($auditId);

        // Revertir el evento a los valores antiguos de esa auditoría
        $event->fill($audit->old_values);
        $event->save();

        return redirect()->route('events.index')
            ->with('success', 'Evento revertido exitosamente.');
    }
}
