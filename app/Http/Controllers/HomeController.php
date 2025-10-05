<?php

namespace App\Http\Controllers;

use App\Models\administracion\Pago;
use Carbon\Carbon;
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

    /*public function index()
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
    }*/
    public function index()
    {
        $hoy = now();

        // -----------------------------
        // PAGOS FINALIZADOS (12 meses atrás)
        // -----------------------------
        $inicioFinalizados = $hoy->copy()->subMonths(11)->startOfMonth();
        $finFinalizados = $hoy->copy()->endOfMonth();

        $meses = ['ENE', 'FEB', 'MAR', 'ABR', 'MAY', 'JUN', 'JUL', 'AGO', 'SEP', 'OCT', 'NOV', 'DIC'];

        // Inicializar array
        $pagosFinalizadosPorMes = [];
        for ($i = 0; $i < 12; $i++) {
            $mes = $inicioFinalizados->copy()->addMonths($i);
            $clave = $mes->format('Y-m');
            $pagosFinalizadosPorMes[$clave] = 0;
        }

        // Obtener totales
        $pagos = Pago::selectRaw('YEAR(fecha) as anio, MONTH(fecha) as mes, SUM(cantidad) as total')
            ->whereBetween('fecha', [$inicioFinalizados, $finFinalizados])
            ->where('finalizado', 1)
            ->groupBy('anio', 'mes')
            ->get();

        foreach ($pagos as $pago) {
            $clave = sprintf('%04d-%02d', $pago->anio, $pago->mes);
            if (isset($pagosFinalizadosPorMes[$clave])) {
                $pagosFinalizadosPorMes[$clave] = (float)$pago->total;
            }
        }

        // Labels tipo "MES-AÑO"
        $labelsFinalizados = [];
        foreach (array_keys($pagosFinalizadosPorMes) as $key) {
            [$anio, $mesNum] = explode('-', $key);
            $labelsFinalizados[] = $meses[intval($mesNum) - 1] . '-' . $anio;
        }

        // -----------------------------
        // PAGOS PENDIENTES (primer al último)
        // -----------------------------
        $primerPagoPendiente = Pago::where('finalizado', 0)->orderBy('fecha')->first();
        $ultimoPagoPendiente = Pago::where('finalizado', 0)->orderBy('fecha', 'desc')->first();

        $pagosPendientesPorMes = [];
        $labelsPendientes = [];

        if ($primerPagoPendiente && $ultimoPagoPendiente) {
            $inicioPendientes = Carbon::parse($primerPagoPendiente->fecha)->startOfMonth();
            $finPendientes = Carbon::parse($ultimoPagoPendiente->fecha)->endOfMonth();

            $periodo = clone $inicioPendientes;
            while ($periodo <= $finPendientes) {
                $clave = $periodo->format('Y-m');
                $pagosPendientesPorMes[$clave] = 0;
                $labelsPendientes[$clave] = $meses[$periodo->month - 1] . '-' . $periodo->year;
                $periodo->addMonth();
            }

            $pagosPendientes = Pago::selectRaw('YEAR(fecha) as anio, MONTH(fecha) as mes, SUM(cantidad) as total')
                ->whereBetween('fecha', [$inicioPendientes, $finPendientes])
                ->where('finalizado', 0)
                ->groupBy('anio', 'mes')
                ->get();

            foreach ($pagosPendientes as $pago) {
                $clave = sprintf('%04d-%02d', $pago->anio, $pago->mes);
                if (isset($pagosPendientesPorMes[$clave])) {
                    $pagosPendientesPorMes[$clave] = (float)$pago->total;
                }
            }
        }

        return view('home', [
            'dataFinalizados' => array_values($pagosFinalizadosPorMes),
            'labelsFinalizados' => array_values($labelsFinalizados),
            'dataPendientes' => array_values($pagosPendientesPorMes),
            'labelsPendientes' => array_values($labelsPendientes),
        ]);
    }
}
