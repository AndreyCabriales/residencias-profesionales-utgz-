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
        'resumen_final',
        'fecha_hora',
        'duracion',
        'catalogo_modalidad_id',
        'catalogo_estado_id',
        'catalogo_resultado_id',
        'lugar',
        'enlace',
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

    public function modalidad()
    {
        return $this->belongsTo(CatalogoItem::class, 'catalogo_modalidad_id');
    }

    public function estado()
    {
        return $this->belongsTo(CatalogoItem::class, 'catalogo_estado_id');
    }

    public function resultado()
    {
        return $this->belongsTo(CatalogoItem::class, 'catalogo_resultado_id');
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function comentarios()
    {
        return $this->morphMany(Comentario::class, 'commentable');
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'fileable');
    }
}
