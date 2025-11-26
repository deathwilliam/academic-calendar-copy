<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Crea varios eventos de ejemplo para el calendario académico.
     */
    public function run(): void
    {
        // Find the admin user dynamically
        $admin = \App\Models\User::where('email', 'admin@calendario.com')->first();
        $adminId = $admin ? $admin->id : 1;

        $events = [
            // Immediate 2025 events
            [
                'title' => 'Inicio de Semestre 2025-A',
                'description' => 'Comienzo oficial de clases para el ciclo escolar.',
                'start_date' => Carbon::create(2025, 1, 15, 8, 0),
                'end_date' => Carbon::create(2025, 1, 15, 18, 0),
                'type' => 'general',
                'is_published' => true,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Periodo de Inscripciones',
                'description' => 'Inscripciones abiertas para alumnos de nuevo ingreso.',
                'start_date' => Carbon::create(2025, 1, 8, 9, 0),
                'end_date' => Carbon::create(2025, 1, 12, 17, 0),
                'type' => 'general',
                'is_published' => true,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Exámenes Parciales - Primer Corte',
                'description' => 'Evaluaciones del primer periodo.',
                'start_date' => Carbon::create(2025, 3, 10, 7, 0),
                'end_date' => Carbon::create(2025, 3, 14, 20, 0),
                'type' => 'exam',
                'is_published' => true,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Semana Santa (Vacaciones)',
                'description' => 'Suspensión de labores académicas.',
                'start_date' => Carbon::create(2025, 4, 14, 0, 0),
                'end_date' => Carbon::create(2025, 4, 25, 23, 59),
                'type' => 'holiday',
                'is_published' => true,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Fin de Semestre',
                'description' => 'Último día de clases.',
                'start_date' => Carbon::create(2025, 6, 20, 8, 0),
                'end_date' => Carbon::create(2025, 6, 20, 18, 0),
                'type' => 'general',
                'is_published' => true,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Entrega de Calificaciones Finales',
                'description' => 'Fecha límite para subir actas.',
                'start_date' => Carbon::create(2025, 6, 25, 9, 0),
                'end_date' => Carbon::create(2025, 6, 27, 17, 0),
                'type' => 'exam',
                'is_published' => true,
                'user_id' => $adminId,
            ],

            // Noviembre 2025
            [
                'title' => 'Consejo Técnico Escolar',
                'description' => 'Reunión mensual de planeación docente.',
                'start_date' => Carbon::create(2025, 11, 5, 8, 0),
                'end_date' => Carbon::create(2025, 11, 5, 13, 0),
                'type' => 'meeting',
                'is_published' => true,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Examen de Historia',
                'description' => 'Evaluación del segundo bloque: Revolución Mexicana.',
                'start_date' => Carbon::create(2025, 11, 12, 10, 0),
                'end_date' => Carbon::create(2025, 11, 12, 12, 0),
                'type' => 'exam',
                'is_published' => true,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Día de la Revolución',
                'description' => 'Suspensión de labores docentes.',
                'start_date' => Carbon::create(2025, 11, 20, 0, 0),
                'end_date' => Carbon::create(2025, 11, 20, 23, 59),
                'type' => 'holiday',
                'is_published' => true,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Feria de Ciencias',
                'description' => 'Exposición de proyectos de alumnos en el patio central.',
                'start_date' => Carbon::create(2025, 11, 25, 9, 0),
                'end_date' => Carbon::create(2025, 11, 26, 14, 0),
                'type' => 'general',
                'is_published' => true,
                'user_id' => $adminId,
            ],

            // Diciembre 2025
            [
                'title' => 'Entrega de Proyectos Finales',
                'description' => 'Fecha límite para subir proyectos a la plataforma.',
                'start_date' => Carbon::create(2025, 12, 5, 23, 59),
                'end_date' => Carbon::create(2025, 12, 5, 23, 59),
                'type' => 'deadline',
                'is_published' => true,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Semana de Exámenes Finales',
                'description' => 'Evaluaciones semestrales todas las materias.',
                'start_date' => Carbon::create(2025, 12, 8, 7, 0),
                'end_date' => Carbon::create(2025, 12, 12, 15, 0),
                'type' => 'exam',
                'is_published' => true,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Festival de Invierno',
                'description' => 'Presentación artística y convivio.',
                'start_date' => Carbon::create(2025, 12, 18, 16, 0),
                'end_date' => Carbon::create(2025, 12, 18, 20, 0),
                'type' => 'general',
                'is_published' => true,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Inicio Vacaciones de Invierno',
                'description' => 'Receso escolar de fin de año.',
                'start_date' => Carbon::create(2025, 12, 19, 0, 0),
                'end_date' => Carbon::create(2026, 1, 6, 23, 59),
                'type' => 'holiday',
                'is_published' => true,
                'user_id' => $adminId,
            ],

            // Enero 2026
            [
                'title' => 'Regreso a Clases',
                'description' => 'Inicio del semestre Primavera 2026.',
                'start_date' => Carbon::create(2026, 1, 7, 7, 0),
                'end_date' => Carbon::create(2026, 1, 7, 15, 0),
                'type' => 'general',
                'is_published' => true,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Junta de Padres de Familia',
                'description' => 'Presentación de objetivos anuales.',
                'start_date' => Carbon::create(2026, 1, 15, 18, 0),
                'end_date' => Carbon::create(2026, 1, 15, 20, 0),
                'type' => 'meeting',
                'is_published' => true,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Inscripción a Talleres',
                'description' => 'Último día para registrarse en talleres deportivos y culturales.',
                'start_date' => Carbon::create(2026, 1, 20, 23, 59),
                'end_date' => Carbon::create(2026, 1, 20, 23, 59),
                'type' => 'deadline',
                'is_published' => true,
                'user_id' => $adminId,
            ],

            // Febrero 2026
            [
                'title' => 'Día de la Constitución',
                'description' => 'Día inhábil oficial.',
                'start_date' => Carbon::create(2026, 2, 5, 0, 0),
                'end_date' => Carbon::create(2026, 2, 5, 23, 59),
                'type' => 'holiday',
                'is_published' => true,
                'user_id' => $adminId,
            ],
            [
                'title' => 'Primer Parcial Física',
                'description' => 'Temas: Cinemática y Dinámica.',
                'start_date' => Carbon::create(2026, 2, 18, 9, 0),
                'end_date' => Carbon::create(2026, 2, 18, 11, 0),
                'type' => 'exam',
                'is_published' => true,
                'user_id' => $adminId,
            ],
        ];

        foreach ($events as $data) {
            Event::firstOrCreate(
                ['title' => $data['title']], // Avoid duplicates
                $data
            );
        }
    }
}
