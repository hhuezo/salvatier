<?php

namespace App\Http\Controllers;

use App\Models\administracion\Pago;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $year = date('Y');

        // Pagos finalizados
        $pagosPorMes = array_fill(0, 12, 0);
        $pagos = Pago::selectRaw('MONTH(fecha) as mes, SUM(cantidad) as total')
            ->whereYear('fecha', $year)
            ->where('finalizado', 1)
            ->groupBy('mes')
            ->get();

        foreach ($pagos as $pago) {
            $pagosPorMes[$pago->mes - 1] = (float)$pago->total;
        }



        return view('home', [
            'data' => $pagosPorMes
        ]);
    }
}
