<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model {
    protected $table = 'documentos';
    protected $fillable = ['alumno_id', 'etapa_id', 'archivo', 'estado', 'retroalimentacion'];
    public function alumno() { return $this->belongsTo(Alumno::class); }
    public function etapa() { return $this->belongsTo(Etapa::class); }
}