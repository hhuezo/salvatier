<?php

namespace App\Models\administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EncargadoPago extends Model
{
    use HasFactory;

    protected $table = 'encargado_pago';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'correo',
        'activo',
    ];
}
