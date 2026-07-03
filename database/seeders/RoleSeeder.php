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

        // Asesores (por carrera)
        $asesoresData = [
            ['name' => 'Ing. Carlos López', 'email' => 'clopez@utgz.mx', 'depto' => 'TIC'],
            ['name' => 'Ing. Roberto Martínez', 'email' => 'rmartinez@utgz.mx', 'depto' => 'Industrial'],
            ['name' => 'Ing. María Elena', 'email' => 'melena@utgz.mx', 'depto' => 'Mecatrónica'],
            ['name' => 'Lic. Patricia Solís', 'email' => 'psolis@utgz.mx', 'depto' => 'Administración'],
        ];

        foreach ($asesoresData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('password')
            ]);
            $user->assignRole($asesorRole);
            Asesor::create([
                'user_id' => $user->id,
                'departamento' => $data['depto']
            ]);
        }

        // Alumnos (datos reales)
        $alumnosData = [
            ['name' => 'Josué Pérez Tapia', 'email' => '23610062@utgz.edu.mx', 'carrera' => 'TSU en Tecnologías de la Información', 'cuatrimestre' => 'Sexto'],
            ['name' => 'Ana Sofía Garza', 'email' => '23610015@utgz.edu.mx', 'carrera' => 'Ingeniería Industrial', 'cuatrimestre' => 'Noveno'],
            ['name' => 'Luis Fernández', 'email' => '23610088@utgz.edu.mx', 'carrera' => 'TSU en Mecatrónica', 'cuatrimestre' => 'Sexto'],
        ];

        foreach ($alumnosData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => bcrypt('password')
            ]);
            $user->assignRole($alumnoRole);
            Alumno::create([
                'user_id' => $user->id,
                'matricula' => explode('@', $data['email'])[0],
                'carrera' => $data['carrera'],
                'cuatrimestre' => $data['cuatrimestre'],
                'etapa_id' => 1 // FOR-06-12 por defecto
            ]);
        }
    }
}