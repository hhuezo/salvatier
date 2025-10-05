<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\Empresa;
use App\Models\administracion\Oficina;
use App\Models\administracion\Pago;
use App\Models\administracion\contrato;
use App\Models\administracion\TipoPago;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index(Request $request)
    {
        // Fecha de inicio: primer día del mes dos meses antes
        $fechaInicio = $request->fechaInicio
            ? Carbon::parse($request->fechaInicio)->format('Y-m-d')
            : Carbon::now()->subMonths(2)->startOfMonth()->format('Y-m-d');

        // Fecha final: último día del mes actual
        $fechaFinal = $request->fechaFinal
            ? Carbon::parse($request->fechaFinal)->format('Y-m-d')
            : Carbon::now()->endOfMonth()->format('Y-m-d');

        // Obtener pagos dentro del rango
        $pagos = Pago::with(['contrato', 'usuario'])
            ->whereBetween('fecha', [$fechaInicio, $fechaFinal])
            ->get();

        return view('administracion.contrato.pago', compact('pagos', 'fechaInicio', 'fechaFinal'));
    }
    public function create()
    {
        $empresas = Empresa::where('activo', 1)->get();
        $oficinas = Oficina::where('activo', 1)->get();
        $tipos_pago = TipoPago::where('activo', 1)->get();
        return view('administracion.contrato.create', compact('empresas', 'oficinas', 'tipos_pago'));
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

        //mensual
        if ($tipoPagoId == 3) {
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
        }
        //ultimo de cada mes
        elseif ($tipoPagoId == 2) {
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
        } else if ($tipoPagoId == 4) {
            $pagos = [];
            $fechaPago = Carbon::parse($fechaPrimerPago);
            $diaDeseado = $fechaPago->day; // Mantener el mismo día

            for ($i = 1; $i <= $numeroCuotas; $i++) {
                $pagos[] = [
                    'numero' => $i,
                    'fecha' => $fechaPago->format('Y-m-d'),
                    'monto' => $valorCuota,
                ];

                // Siguiente cuota: sumar 3 meses
                $fechaPago = $fechaPago->copy()->addMonthsNoOverflow(3);

                // Ajustar el día si el mes nuevo tiene menos días
                if ($diaDeseado > $fechaPago->daysInMonth) {
                    $fechaPago->day = $fechaPago->daysInMonth;
                } else {
                    $fechaPago->day = $diaDeseado;
                }
            }
        }





        return view('administracion.contrato.detalle', [
            'pagos' => $pagos,
            'monto_contratado' => $montoContratado,
            'primer_abono' => $primerAbono,
            'numero_cuotas' => $numeroCuotas,
            'tipo_pago_id' => $tipoPagoId,
        ]);
    }




    public function contrato_store(Request $request)
    {
        $messages = [
            'fecha_contrato.required' => 'La fecha de contrato es obligatoria.',
            'tipo_pago_id.required' => 'Debes seleccionar un tipo de pago.',
            'empresa_id.required' => 'Debes seleccionar una empresa.',
            'monto_contratado.required' => 'El monto contratado es obligatorio.',
            'monto_contratado.numeric' => 'El monto contratado debe ser un número válido.',
            'oficina_id.required' => 'Debes seleccionar una oficina.',
            'fecha_primer_pago.required' => 'La fecha del primer pago es obligatoria.',
        ];

        $validatedData = $request->validate([
            'fecha_contrato' => 'required|date',
            'tipo_pago_id' => 'required|integer',
            'empresa_id' => 'required|integer',
            'monto_contratado' => 'required|numeric|min:0.01',
            'oficina_id' => 'required|integer',
            'fecha_primer_pago' => function ($attribute, $value, $fail) use ($request) {
                if (in_array($request->tipo_pago_id, [2, 3, 4])) {
                    if ($value === null || !is_numeric(strtotime($value))) {
                        $fail('La fecha del primer pago es obligatoria.');
                    }
                }
            },
            'primer_abono' => function ($attribute, $value, $fail) use ($request) {
                if (in_array($request->tipo_pago_id, [2, 3, 4])) {
                    if ($value === null || !is_numeric($value)) {
                        $fail('El primer abono es obligatorio y debe ser un número.');
                    }
                }
            },
            'pago_minimo' => function ($attribute, $value, $fail) use ($request) {
                if (in_array($request->tipo_pago_id, [2, 3, 4])) {
                    if ($value === null || !is_numeric($value)) {
                        $fail('El pago mínimo es obligatorio y debe ser un número.');
                    }
                }
            },
            'numero_cuotas' => function ($attribute, $value, $fail) use ($request) {
                if (in_array($request->tipo_pago_id, [2, 3, 4])) {
                    if ($value === null || !is_numeric($value) || intval($value) < 1) {
                        $fail('El número de cuotas es obligatorio y debe ser mayor o igual a 1.');
                    }
                }
            },
        ], $messages);

        $contrato = new contrato();
        $contrato->fecha_contrato = $request->fecha_contrato;
        $contrato->empresa_id = $request->empresa_id;
        $contrato->oficina_id = $request->oficina_id;
        $contrato->tipo_pago_id = $request->tipo_pago_id;
        $contrato->estado_contrato_id = 1;
        $contrato->monto_contratado = $request->monto_contratado;
        $contrato->primer_abono = $request->primer_abono;
        $contrato->pago_minimo = $request->pago_minimo;
        $contrato->detalle = $request->detalle;
        $contrato->numero_cuotas = $request->numero_cuotas;
        $contrato->usuario_creador = auth()->user()->id ?? null;
        $contrato->save();

        if (in_array($contrato->tipo_pago_id, [2, 3, 4])) {
            $montoRestante = $contrato->monto_contratado - ($contrato->primer_abono ?? 0);
            $numeroCuotas = max(1, $contrato->numero_cuotas);
            $valorCuota = round($montoRestante / $numeroCuotas, 2);
            $fechaPago = Carbon::parse($contrato->fecha_primer_pago);
            $pagos = [];

            if ($contrato->tipo_pago_id == 3) {
                $diaDeseado = $fechaPago->day;
                for ($i = 1; $i <= $numeroCuotas; $i++) {
                    $pagos[] = [
                        'numero' => $i,
                        'fecha' => $fechaPago->format('Y-m-d'),
                        'cantidad' => $valorCuota,
                        'contrato_id' => $contrato->id,
                        'usuario_creador' => auth()->user()->id ?? null,
                    ];
                    $fechaPago = $fechaPago->copy()->addMonthNoOverflow();
                    $ultimoDiaMes = $fechaPago->copy()->endOfMonth()->day;
                    $fechaPago->day = min($diaDeseado, $ultimoDiaMes);
                }
            } elseif ($contrato->tipo_pago_id == 2) {
                $pagos[] = [
                    'numero' => 1,
                    'fecha' => $fechaPago->format('Y-m-d'),
                    'cantidad' => $valorCuota,
                    'contrato_id' => $contrato->id,
                    'usuario_creador' => auth()->user()->id ?? null,
                ];
                $fechaSiguiente = $fechaPago->copy();
                if (!$fechaPago->isSameDay($fechaPago->copy()->endOfMonth())) {
                    $fechaSiguiente = $fechaPago->copy()->endOfMonth();
                } else {
                    $fechaSiguiente = $fechaPago->copy()->addMonthNoOverflow()->endOfMonth();
                }
                for ($i = 2; $i <= $numeroCuotas; $i++) {
                    $pagos[] = [
                        'numero' => $i,
                        'fecha' => $fechaSiguiente->format('Y-m-d'),
                        'cantidad' => $valorCuota,
                        'contrato_id' => $contrato->id,
                        'usuario_creador' => auth()->user()->id ?? null,
                    ];
                    $fechaSiguiente = $fechaSiguiente->copy()->addMonthNoOverflow()->endOfMonth();
                }
            } elseif ($contrato->tipo_pago_id == 4) {
                $diaDeseado = $fechaPago->day;
                for ($i = 1; $i <= $numeroCuotas; $i++) {
                    $pagos[] = [
                        'numero' => $i,
                        'fecha' => $fechaPago->format('Y-m-d'),
                        'cantidad' => $valorCuota,
                        'contrato_id' => $contrato->id,
                        'usuario_creador' => auth()->user()->id ?? null,
                    ];
                    $fechaPago = $fechaPago->copy()->addMonthsNoOverflow(3);
                    $fechaPago->day = min($diaDeseado, $fechaPago->daysInMonth);
                }
            }

            foreach ($pagos as $pagoData) {
                Pago::create($pagoData);
            }
        }

        return redirect()
            ->route('contrato.show', ['id' => $contrato->id])
            ->with('success', 'contrato guardado correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'contrato_id' => 'required|exists:contrato,id',
            'numero'      => 'required|numeric',
            'fecha'       => 'required|date',
            'cantidad'    => 'required|numeric|min:0.01',
            'finalizado'  => 'nullable|boolean',
            'observacion' => 'nullable|string|max:500',
        ], [
            'contrato_id.required' => 'El pago debe estar asociado a un contrato.',
            'contrato_id.exists'   => 'El contrato seleccionado no existe.',

            'numero.required'      => 'El número del pago es obligatorio.',
            'numero.numeric'       => 'El número debe ser un valor numérico.',

            'fecha.required'       => 'La fecha del pago es obligatoria.',
            'fecha.date'           => 'La fecha debe tener un formato válido (AAAA-MM-DD).',

            'cantidad.required'    => 'El monto del pago es obligatorio.',
            'cantidad.numeric'     => 'El monto debe ser un valor numérico.',
            'cantidad.min'         => 'El monto debe ser mayor a 0.01.',

            'finalizado.boolean'   => 'El valor de finalizado es incorrecto.',

            'observacion.string'   => 'La observación debe ser texto.',
            'observacion.max'      => 'La observación no puede superar los 500 caracteres.',
        ]);

        $pago = new Pago();
        $pago->contrato_id  = $request->contrato_id;
        $pago->numero       = $request->numero;
        $pago->fecha        = $request->fecha;
        $pago->cantidad     = $request->cantidad;
        $pago->finalizado   = $request->has('finalizado') ? 1 : 0;
        $pago->observacion  = $request->observacion;
        $pago->usuario_creador = auth()->id();
        $pago->save();

        return back()->with('success', 'Pago registrado correctamente.');
    }


    public function update(Request $request, $id)
    {
        // Validaciones con mensajes personalizados
        $request->validate([
            'numero' => 'required|numeric',
            'fecha' => 'required|date',
            'cantidad' => 'required|numeric|min:0.01',
            'observacion' => 'nullable|string|max:500',
        ], [
            'numero.required'   => 'El número es obligatorio.',
            'numero.numeric'    => 'El número debe ser un valor numérico.',

            'fecha.required'    => 'La fecha es obligatoria.',
            'fecha.date'        => 'La fecha debe tener un formato válido (AAAA-MM-DD).',

            'cantidad.required' => 'La cantidad es obligatoria.',
            'cantidad.numeric'  => 'La cantidad debe ser numérica.',
            'cantidad.min'      => 'La cantidad debe ser mayor a 0.01.',

            'observacion.string' => 'La observación debe ser texto.',
            'observacion.max'    => 'La observación no puede superar los 500 caracteres.',
        ]);

        $pago = Pago::findOrFail($id);
        $pago->numero = $request->numero;
        $pago->fecha = $request->fecha;
        $pago->cantidad = $request->cantidad;
        $pago->finalizado = $request->has('finalizado') ? 1 : 0;
        $pago->observacion = $request->observacion;

        $pago->save();

        return back()->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();

        return back()->with('success', 'Pago eliminado correctamente.');
    }
}
