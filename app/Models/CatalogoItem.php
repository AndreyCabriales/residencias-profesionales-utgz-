<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogoItem extends Model
{
    protected $fillable = ['catalogo_id', 'nombre', 'valor', 'orden', 'activo'];

    public function catalogo()
    {
        return $this->belongsTo(Catalogo::class);
    }
}
