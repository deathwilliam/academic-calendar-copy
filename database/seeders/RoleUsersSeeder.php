<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Seeder de Usuarios con Roles
 * 
 * Crea usuarios de prueba para cada rol del sistema:
 * - Administrador: Acceso completo
 * - Editor: Crear y editar eventos
 * - Auditor: Ver historial de cambios
 * - Usuario regular: Sin acceso al panel de administración
 * 
 * Todos los usuarios tienen la contraseña: 'password'
 */
class RoleUsersSeeder extends Seeder
{
    /**
     * Ejecutar el seeder
     * 
     * Crea o actualiza los usuarios de prueba en la base de datos.
     */
    public function run(): void
    {
        // Administrador - Acceso completo al sistema
        User::updateOrCreate(
            ['email' => 'admin@calendario.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('password'),
                'role' => 'administrador',
            ]
        );

        // Editor - Puede crear y editar eventos
        User::updateOrCreate(
            ['email' => 'editor@calendario.com'],
            [
                'name' => 'Editor',
                'password' => Hash::make('password'),
                'role' => 'editor',
            ]
        );

        // Auditor - Solo puede ver el historial de cambios
        User::updateOrCreate(
            ['email' => 'auditor@calendario.com'],
            [
                'name' => 'Auditor',
                'password' => Hash::make('password'),
                'role' => 'auditor',
            ]
        );
    }
}
