<?php

namespace App\Models\administracion;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesoria extends Model
{
    use HasFactory;

    protected $table = 'asesoria';

    protected $fillable = [
        'descripcion',
        'fecha',
        'hora',
        'estado_asesoria_id',
        'modo_asesoria_id',
        'tipo_asesoria_id',
        'user_id',
    ];

    // Relaciones
    public function estado()
    {
        return $this->belongsTo(EstadoAsesoria::class, 'estado_asesoria_id');
    }

    public function modo()
    {
        return $this->belongsTo(ModoAsesoria::class, 'modo_asesoria_id');
    }

    public function tipo()
    {
        return $this->belongsTo(TipoAsesoria::class, 'tipo_asesoria_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
