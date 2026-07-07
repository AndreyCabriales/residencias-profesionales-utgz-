<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    protected $fillable = ['nombre', 'descripcion'];

    public function items()
    {
        return $this->hasMany(CatalogoItem::class);
    }
}
