<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model {
    protected $table = 'asignaciones';
    protected $fillable = ['alumno_id', 'asesor_id'];
    public function alumno() { return $this->belongsTo(Alumno::class); }
    public function asesor() { return $this->belongsTo(Asesor::class); }
}