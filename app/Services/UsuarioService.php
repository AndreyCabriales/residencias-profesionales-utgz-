<?php

namespace App\Services;

use App\Models\User;
use App\Models\Alumno;
use App\Models\Asesor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class UsuarioService
{
    /**
     * Crea un usuario con rol 'alumno' y su registro en la tabla alumnos.
     */
    public function crearAlumno(array $data): Alumno
    {
        return DB::transaction(function () use ($data) {
            // 1. Crear el User
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'] ?? 'password'),
            ]);

            // 2. Asignar rol de Spatie
            $user->assignRole('alumno');

            // 3. Crear el registro específico de Alumno
            $alumno = Alumno::create([
                'user_id' => $user->id,
                'matricula' => $data['matricula'],
                'carrera' => $data['carrera'] ?? null,
                'cuatrimestre' => $data['cuatrimestre'] ?? null,
                'etapa_id' => 1, // Todos inician en la etapa 1
            ]);

            // 4. Crear asignación si se envió un asesor
            if (!empty($data['asesor_id'])) {
                \App\Models\Asignacion::create([
                    'alumno_id' => $alumno->id,
                    'asesor_id' => $data['asesor_id'],
                ]);
            }

            return $alumno;
        });
    }

    /**
     * Crea un usuario con rol 'asesor' y su registro en la tabla asesores.
     */
    public function crearAsesor(array $data): Asesor
    {
        return DB::transaction(function () use ($data) {
            // 1. Crear el User
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password'] ?? 'password'),
            ]);

            // 2. Asignar rol de Spatie
            $user->assignRole('asesor');

            // 3. Crear el registro específico de Asesor
            $asesor = Asesor::create([
                'user_id' => $user->id,
                'departamento' => $data['departamento'] ?? null,
            ]);

            return $asesor;
        });
    }
}
