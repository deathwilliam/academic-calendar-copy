<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * Modelo de Evento
 * 
 * Representa un evento académico en el calendario.
 * Incluye funcionalidad de auditoría para rastrear todos los cambios.
 * 
 * Tipos de eventos disponibles:
 * - general: Eventos generales
 * - exam: Exámenes
 * - holiday: Vacaciones/Días festivos
 * - meeting: Reuniones
 * - deadline: Fechas límite
 */
class Event extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    /**
     * Atributos que se pueden asignar masivamente
     * 
     * @var array<string>
     */
    protected $fillable = [
        'title',          // Título del evento
        'description',    // Descripción detallada
        'start_date',     // Fecha y hora de inicio
        'end_date',       // Fecha y hora de finalización
        'type',           // Tipo de evento (general, exam, holiday, etc.)
        'is_published',   // Estado de publicación (visible en calendario público)
        'user_id',        // ID del usuario que creó el evento
    ];

    /**
     * Conversión automática de tipos de datos
     * 
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',    // Convertir a objeto DateTime
        'end_date' => 'datetime',      // Convertir a objeto DateTime
        'is_published' => 'boolean',   // Convertir a booleano
    ];

    /**
     * Relación con el modelo User
     * 
     * Un evento pertenece a un usuario (quien lo creó).
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
