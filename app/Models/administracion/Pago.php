<?php

namespace App\Models\administracion;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pago';
    public $timestamps = false;

    protected $fillable = [
        'numero',
        'contrato_id',
        'fecha',
        'cantidad',
        'usuario_creador',
    ];

    public function servicio()
    {
        return $this->belongsTo(Contrato::class, 'contrato_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_creador');
    }
}
