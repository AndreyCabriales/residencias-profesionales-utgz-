<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model {
    protected $table = 'alumnos';
    protected $fillable = ['user_id', 'matricula', 'etapa_id', 'carrera', 'cuatrimestre', 'estado_residencia', 'fecha_finalizacion'];
    
    protected $casts = [
        'estado_residencia' => \App\Enums\ResidenciaEstado::class,
        'fecha_finalizacion' => 'datetime',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function etapa() { return $this->belongsTo(Etapa::class); }
    public function documentos() { return $this->hasMany(Documento::class); }
    public function asignacion() { return $this->hasOne(Asignacion::class); }
    public function companyAdvisor() { return $this->hasOne(CompanyAdvisor::class); }
}