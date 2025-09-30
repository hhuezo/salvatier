<?php

namespace App\Http\Controllers\usuario;

use App\Http\Controllers\Controller;
use App\Models\administracion\Empresa;
use App\Models\administracion\Oficina;
use App\Models\administracion\Servicio;
use App\Models\administracion\TipoPago;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $servicios = Servicio::with(['empresa', 'oficina', 'tipo_pago'])->get();

        return view('administracion.servicio.index', compact('servicios'));
    }
    public function create()
    {
        $empresas = Empresa::where('activo', 1)->get();
        $oficinas = Oficina::where('activo', 1)->get();
        $tipos_pago = TipoPago::where('activo', 1)->get();
        return view('administracion.servicio.create', compact('empresas', 'oficinas', 'tipos_pago'));
    }




    public function previsualizacion(Request $request)
    {
        $fechaPrimerPago = $request->get('fecha_primer_pago'); // yyyy-mm-dd
        $montoContratado = (float) $request->get('monto_contratado');
        $primerAbono = (float) $request->get('primer_abono', 0);
        $numeroCuotas = (int) $request->get('numero_cuotas', 1);
        $tipoPagoId = $request->get('tipo_pago_id');

        if ($numeroCuotas < 1) {
            $numeroCuotas = 1;
        }

        $montoRestante = $montoContratado - $primerAbono;
        $valorCuota = round($montoRestante / $numeroCuotas, 2);
        $pagos = [];

        $fechaPago = Carbon::parse($fechaPrimerPago);

        if ($tipoPagoId == 2) {
            $pagos = [];
            $fechaInicial = Carbon::parse($fechaPrimerPago);
            $diaDeseado = $fechaInicial->day; // Día que queremos respetar
            $fechaPago = $fechaInicial->copy();

            for ($i = 1; $i <= $numeroCuotas; $i++) {
                $pagos[] = [
                    'numero' => $i,
                    'fecha' => $fechaPago->format('Y-m-d'),
                    'monto' => $valorCuota,
                ];

                // Sumar un mes sin overflow
                $fechaPago = $fechaPago->copy()->addMonthNoOverflow();

                // Ajustar al día deseado o al último día del mes
                $ultimoDiaMes = $fechaPago->copy()->endOfMonth()->day;
                $fechaPago->day = min($diaDeseado, $ultimoDiaMes);
            }
        } elseif ($tipoPagoId == 3) {
            $pagos = [];

            // Primera cuota = fechaPrimerPago
            $pagos[] = [
                'numero' => 1,
                'fecha' => $fechaPago->format('Y-m-d'),
                'monto' => $valorCuota,
            ];

            // Fecha para la siguiente cuota
            $fechaSiguiente = $fechaPago->copy();

            // Si la primera cuota no es fin de mes, segunda cuota = fin de mes de ese mes
            if (!$fechaPago->isSameDay($fechaPago->copy()->endOfMonth())) {
                $fechaSiguiente = $fechaPago->copy()->endOfMonth();
            } else {
                $fechaSiguiente = $fechaPago->copy()->addMonthNoOverflow()->endOfMonth();
            }

            // Generar el resto de cuotas
            for ($i = 2; $i <= $numeroCuotas; $i++) {
                $pagos[] = [
                    'numero' => $i,
                    'fecha' => $fechaSiguiente->format('Y-m-d'),
                    'monto' => $valorCuota,
                ];

                // Siguiente cuota: sumamos 1 mes sin overflow y ajustamos al fin de mes
                $fechaSiguiente = $fechaSiguiente->copy()->addMonthNoOverflow()->endOfMonth();
            }
        }




        return view('administracion.servicio.detalle', [
            'pagos' => $pagos,
            'monto_contratado' => $montoContratado,
            'primer_abono' => $primerAbono,
            'numero_cuotas' => $numeroCuotas,
            'tipo_pago_id' => $tipoPagoId,
        ]);
    }




    public function servicio_store(Request $request)
    {
        dd("**");
        return view('administracion.servicio.create');
    }
}
