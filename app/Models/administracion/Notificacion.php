<?php

namespace App\Models\administracion;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
    use HasFactory;

    protected $table = 'notificacion';

    protected $fillable = [
        'asesoria_id',
        'user_id',
        'mensaje',
        'archivo',
        'fecha',
        'leido',
    ];

    // Relación con el usuario
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function asesoria()
    {
        return $this->belongsTo(Asesoria::class, 'asesoria_id');
    }
}
