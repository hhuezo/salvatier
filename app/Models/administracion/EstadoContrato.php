<?php

namespace App\Models\administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoContrato extends Model
{
    use HasFactory;
     protected $table = 'estado_contrato';

    protected $fillable = [
        'nombre',
    ];

    public function servicios()
    {
        return $this->hasMany(Contrato::class, 'estado_contrato_id');
    }
}
