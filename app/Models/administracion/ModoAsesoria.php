<?php

namespace App\Models\administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModoAsesoria extends Model
{
     use HasFactory;

    protected $table = 'modo_asesoria';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre','costo','activo',
    ];

    // Relación con Asesoria (si quieres)
    public function asesorias()
    {
        return $this->hasMany(Asesoria::class, 'modo_asesoria_id');
    }
}
