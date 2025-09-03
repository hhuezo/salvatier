<?php

namespace App\Models\administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoAsesoria extends Model
{
     use HasFactory;

    protected $table = 'estado_asesoria';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
    ];

    // Relación con Asesoria (si quieres)
    public function asesorias()
    {
        return $this->hasMany(Asesoria::class, 'estado_asesoria_id');
    }
}
