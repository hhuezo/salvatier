<?php

namespace App\Http\Controllers\usuario;

use App\Http\Controllers\Controller;

class PagoController extends Controller
{
    public function create()
    {
        return view('usuario.pago.create');
    }
}
