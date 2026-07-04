<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Documento;
use App\Models\Etapa;
use App\Models\Alumno;
use App\Models\Asesor;
use App\Models\Asignacion;
use App\Enums\DocumentoEstado;
use Spatie\Permission\Models\Role;

class DocumentoPolicyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Seed roles required by the application
        Role::create(['name' => 'coordinador']);
        Role::create(['name' => 'asesor']);
        Role::create(['name' => 'alumno']);
        Role::create(['name' => 'servicios_escolares']);
    }

    public function test_servicios_escolares_cannot_evaluate_asesor_documents(): void
    {
        $userServicios = User::factory()->create();
        $userServicios->assignRole('servicios_escolares');

        $etapaAcademica = clone(new Etapa());
        $etapaAcademica->forceFill(['tipo' => 'asesor', 'nombre' => 'Reporte', 'codigo' => 'F1', 'descripcion' => 'D', 'orden' => 1])->save();
        
        $alumno = new Alumno();
        $alumno->forceFill(['user_id' => User::factory()->create()->id, 'etapa_id' => $etapaAcademica->id, 'matricula' => '123', 'carrera' => 'TI', 'cuatrimestre' => '6'])->save();
        
        $documento = clone(new Documento());
        $documento->forceFill(['alumno_id' => $alumno->id, 'etapa_id' => $etapaAcademica->id, 'estado' => DocumentoEstado::EnRevision, 'archivo' => 'd.pdf'])->save();

        $this->assertFalse($userServicios->can('evaluate', $documento));
    }

    public function test_servicios_escolares_can_evaluate_servicios_escolares_documents(): void
    {
        $userServicios = User::factory()->create();
        $userServicios->assignRole('servicios_escolares');

        $etapaAdmin = clone(new Etapa());
        $etapaAdmin->forceFill(['tipo' => 'servicios_escolares', 'nombre' => 'Carta', 'codigo' => 'F2', 'descripcion' => 'D', 'orden' => 1])->save();
        
        $alumno = new Alumno();
        $alumno->forceFill(['user_id' => User::factory()->create()->id, 'etapa_id' => $etapaAdmin->id, 'matricula' => '1234', 'carrera' => 'TI', 'cuatrimestre' => '6'])->save();
        
        $documento = clone(new Documento());
        $documento->forceFill(['alumno_id' => $alumno->id, 'etapa_id' => $etapaAdmin->id, 'estado' => DocumentoEstado::EnRevision, 'archivo' => 'd.pdf'])->save();

        $this->assertTrue($userServicios->can('evaluate', $documento));
    }

    public function test_asesor_cannot_evaluate_servicios_escolares_documents(): void
    {
        $userAsesor = User::factory()->create();
        $userAsesor->assignRole('asesor');
        $asesor = new Asesor();
        $asesor->forceFill(['user_id' => $userAsesor->id, 'departamento' => 'TI'])->save();

        $etapaAdmin = clone(new Etapa());
        $etapaAdmin->forceFill(['tipo' => 'servicios_escolares', 'nombre' => 'Carta', 'codigo' => 'F2', 'descripcion' => 'D', 'orden' => 1])->save();
        
        $alumno = new Alumno();
        $alumno->forceFill(['user_id' => User::factory()->create()->id, 'etapa_id' => $etapaAdmin->id, 'matricula' => '1235', 'carrera' => 'TI', 'cuatrimestre' => '6'])->save();
        
        $asignacion = new Asignacion();
        $asignacion->forceFill(['alumno_id' => $alumno->id, 'asesor_id' => $asesor->id])->save();

        $documento = clone(new Documento());
        $documento->forceFill(['alumno_id' => $alumno->id, 'etapa_id' => $etapaAdmin->id, 'estado' => DocumentoEstado::EnRevision, 'archivo' => 'd.pdf'])->save();

        $this->assertFalse($userAsesor->can('evaluate', $documento));
    }

    public function test_asesor_can_evaluate_asesor_documents(): void
    {
        $userAsesor = User::factory()->create();
        $userAsesor->assignRole('asesor');
        $asesor = new Asesor();
        $asesor->forceFill(['user_id' => $userAsesor->id, 'departamento' => 'TI'])->save();

        $etapaAcademica = clone(new Etapa());
        $etapaAcademica->forceFill(['tipo' => 'asesor', 'nombre' => 'Reporte', 'codigo' => 'F1', 'descripcion' => 'D', 'orden' => 1])->save();
        
        $alumno = new Alumno();
        $alumno->forceFill(['user_id' => User::factory()->create()->id, 'etapa_id' => $etapaAcademica->id, 'matricula' => '1236', 'carrera' => 'TI', 'cuatrimestre' => '6'])->save();
        
        $asignacion = new Asignacion();
        $asignacion->forceFill(['alumno_id' => $alumno->id, 'asesor_id' => $asesor->id])->save();

        $documento = clone(new Documento());
        $documento->forceFill(['alumno_id' => $alumno->id, 'etapa_id' => $etapaAcademica->id, 'estado' => DocumentoEstado::EnRevision, 'archivo' => 'd.pdf'])->save();

        $this->assertTrue($userAsesor->can('evaluate', $documento));
    }
}
