<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyAdvisor extends Model
{
    protected $fillable = [
        'alumno_id',
        'nombre',
        'puesto',
        'empresa',
        'telefono',
        'correo'
    ];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}
