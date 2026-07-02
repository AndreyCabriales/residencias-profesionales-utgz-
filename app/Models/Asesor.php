<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asesor extends Model {
    protected $table = 'asesores';
    protected $fillable = ['user_id', 'departamento'];
    public function user() { return $this->belongsTo(User::class); }
    public function asignaciones() { return $this->hasMany(Asignacion::class); }
}