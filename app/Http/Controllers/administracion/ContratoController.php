<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\administracion\Contrato;
use App\Models\administracion\Empresa;
use App\Models\administracion\Oficina;
use App\Models\administracion\Pago;
use App\Models\administracion\TipoPago;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContratoController extends Controller
{
    public function index()
    {
        $contratos = Contrato::with(['empresa', 'oficina', 'tipo_pago'])->get();



        return view('administracion.contrato.index', compact('contratos'));
    }


    public function create()
    {
        $empresas = Empresa::where('activo', 1)->get();
        $oficinas = Oficina::where('activo', 1)->get();
        $tipos_pago = TipoPago::where('activo', 1)->get();
        return view('administracion.contrato.create', compact('empresas', 'oficinas', 'tipos_pago'));
    }


    public function store(Request $request)
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

        $contrato = new Contrato();
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
            ->route('contrato.show', ['contrato' => $contrato->id])
            ->with('success', 'Contrato guardado correctamente.');
    }


    public function show(string $id)
    {
        $contrato = Contrato::findOrFail($id);

        return view('administracion.contrato.show', compact('contrato'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
