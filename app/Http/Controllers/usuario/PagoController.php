<?php

namespace App\Http\Controllers\usuario;

use App\Http\Controllers\Controller;

class PagoController extends Controller
{
    public function index()
    {
        return view('usuario.pago.create');
    }
    public function create()
    {
        return view('usuario.pago.create');
    }
}
