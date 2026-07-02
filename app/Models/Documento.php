<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\DocumentoEstado;

class Documento extends Model
{
    use HasFactory;

    protected $table = 'documentos';
    protected $fillable = ['alumno_id', 'etapa_id', 'archivo', 'estado', 'retroalimentacion'];
    
    protected $casts = [
        'estado' => DocumentoEstado::class,
    ];

    public function alumno() { return $this->belongsTo(Alumno::class); }
    public function etapa() { return $this->belongsTo(Etapa::class); }
}