<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Alumno;
use App\Models\Asesor;

class RoleSeeder extends Seeder {
    public function run(): void {
        $coordinadorRole = Role::create(['name' => 'coordinador']);
        $asesorRole = Role::create(['name' => 'asesor']);
        $alumnoRole = Role::create(['name' => 'alumno']);

        $coordinador = User::create([
            'name' => 'Coordinador UTGZ',
            'email' => 'coordinador@utgz.mx',
            'password' => bcrypt('Admin1234!')
        ]);
        $coordinador->assignRole($coordinadorRole);

        // Asesores
        for ($i = 1; $i <= 2; $i++) {
            $user = User::create([
                'name' => "Asesor $i",
                'email' => "asesor$i@utgz.mx",
                'password' => bcrypt('password')
            ]);
            $user->assignRole($asesorRole);
            Asesor::create([
                'user_id' => $user->id,
                'departamento' => 'Sistemas'
            ]);
        }

        // Alumnos
        for ($i = 1; $i <= 3; $i++) {
            $user = User::create([
                'name' => "Alumno $i",
                'email' => "alumno$i@utgz.mx",
                'password' => bcrypt('password')
            ]);
            $user->assignRole($alumnoRole);
            Alumno::create([
                'user_id' => $user->id,
                'matricula' => 'UTGZ' . rand(1000, 9999),
                'etapa_id' => 1 // Primera etapa por defecto
            ]);
        }
    }
}