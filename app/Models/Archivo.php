<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    protected $fillable = [
        'user_id',
        'fileable_type',
        'fileable_id',
        'nombre',
        'ruta',
        'disk',
        'mime_type',
        'size',
        'version'
    ];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
