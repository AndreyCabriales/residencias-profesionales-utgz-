<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesoria extends Model
{
    use HasFactory;

    protected $table = 'asesorias';

    protected $fillable = [
        'asesor_id',
        'alumno_id',
        'titulo',
        'descripcion',
        'observaciones',
        'fecha_hora',
        'duracion',
        'modalidad',
        'lugar',
        'provider',
        'enlace',
        'estado',
        'recurrencia',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
        'duracion' => 'integer',
    ];

    public function asesor()
    {
        return $this->belongsTo(Asesor::class);
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function archivos()
    {
        return $this->hasMany(AsesoriaArchivo::class);
    }
}
