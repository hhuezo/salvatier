<?php

namespace App\Models\administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicio';
    public $timestamps = false;

    protected $fillable = [
        'fecha_contrato',
        'empresa_id',
        'oficina_id',
        'monto_contratado',
        'primer_abono',
        'pago_minimo',
        'detalle',
        'numero_cuotas',
        'teimestamp',
        'usuario_creador',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function oficina()
    {
        return $this->belongsTo(Oficina::class, 'oficina_id');
    }
}
