<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsesoriaArchivo extends Model
{
    use HasFactory;

    protected $table = 'asesoria_archivos';

    protected $fillable = [
        'asesoria_id',
        'nombre_archivo',
        'ruta',
    ];

    public function asesoria()
    {
        return $this->belongsTo(Asesoria::class);
    }
}
