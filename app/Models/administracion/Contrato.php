<?php

namespace App\Models\administracion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $table = 'contrato';
    public $timestamps = false;

    protected $fillable = [
        'fecha_contrato',
        'empresa_id',
        'oficina_id',
        'tipo_pago_id',
        'monto_contratado',
        'primer_abono',
        'pago_minimo',
        'detalle',
        'numero_cuotas',
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

    public function tipo_pago()
    {
        return $this->belongsTo(TipoPago::class, 'tipo_pago_id');
    }

    public function estado_contrato()
    {
        return $this->belongsTo(EstadoContrato::class, 'estado_contrato_id');
    }

     public function pagos()
    {
        return $this->hasMany(Pago::class, 'contrato_id');
    }
}
