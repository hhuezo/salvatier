<?php

namespace App\Models\administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoServicio extends Model
{
    use HasFactory;

    protected $table = 'estado_servicio';

    protected $fillable = [
        'nombre',
    ];

    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'estado_servicio_id');
    }
}
