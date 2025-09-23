<?php

namespace App\Http\Controllers\usuario;

use App\Http\Controllers\Controller;
use App\Models\administracion\Asesoria;
use App\Models\administracion\AsesoriaHistorial;
use App\Models\administracion\ModoAsesoria;
use App\Models\administracion\TipoAsesoria;
use App\Models\seguridad\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class AsesoriaUsuarioController extends Controller
{

    public function index()
    {
        $asesorias = Asesoria::with(['estado', 'modo', 'tipo', 'user'])->where('user_id', auth()->user()->id)->get();
        $tipos = TipoAsesoria::get();
        $modos = ModoAsesoria::get();

        return view('usuario.asesoria.index', compact('asesorias', 'tipos', 'modos'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha'             => 'required|date|after:today',
            'hora'              => 'required|date_format:H:i',
            'tipo_asesoria_id'  => 'required|exists:tipo_asesoria,id',
            'modo_asesoria_id'  => 'required|exists:modo_asesoria,id',
            'descripcion'       => 'nullable|string|max:1000',
        ], [
            'fecha.required'    => 'La fecha es obligatoria.',
            'fecha.date'        => 'La fecha debe tener un formato válido.',
            'fecha.after'       => 'La fecha debe ser mayor a la fecha actual.',

            'hora.required'     => 'La hora es obligatoria.',
            'hora.date_format'  => 'La hora debe tener el formato HH:mm.',

            'tipo_asesoria_id.required' => 'Debe seleccionar un tipo de asesoría.',
            'tipo_asesoria_id.exists'   => 'El tipo de asesoría seleccionado no es válido.',

            'modo_asesoria_id.required' => 'Debe seleccionar un modo de asesoría.',
            'modo_asesoria_id.exists'   => 'El modo de asesoría seleccionado no es válido.',

            'descripcion.string' => 'La descripción debe ser texto válido.',
            'descripcion.max'    => 'La descripción no puede superar los 1000 caracteres.',
        ]);

        DB::beginTransaction();

        try {
            $asesoria = new Asesoria();
            $asesoria->descripcion       = $validated['descripcion'] ?? null;
            $asesoria->fecha             = $validated['fecha'];
            $asesoria->hora              = $validated['hora'];
            $asesoria->tipo_asesoria_id  = $validated['tipo_asesoria_id'];
            $asesoria->modo_asesoria_id  = $validated['modo_asesoria_id'];
            $asesoria->estado_asesoria_id = 1;
            $asesoria->user_id           = auth()->id();
            $asesoria->save();

            $historial = new AsesoriaHistorial();
            $historial->descripcion        = $asesoria->descripcion;
            $historial->fecha              = $asesoria->fecha;
            $historial->hora               = $asesoria->hora;
            $historial->enlace             = null;
            $historial->asesoria_id        = $asesoria->id;
            $historial->estado_asesoria_id = $asesoria->estado_asesoria_id;
            $historial->tipo_asesoria_id   = $asesoria->tipo_asesoria_id;
            $historial->modo_asesoria_id   = $asesoria->modo_asesoria_id;
            $historial->user_id            = $asesoria->user_id;
            $historial->save();

            DB::commit();

            return redirect()->back()->with('success', 'La asesoría ha sido programada exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'error' => 'Ocurrió un error al registrar la asesoría: ' . $e->getMessage()
            ]);
        }
    }


    public function show(string $id)
    {
        $asesoria = Asesoria::findOrFail($id);
        $configuracion = Configuracion::first();

        // Consumir API de regiones
        $response = Http::get('http://44.212.113.88:8081/api/wompi/regiones');

        $regiones = [];
        if ($response->successful()) {
            $regiones = $response->json();
        }

        return view('usuario.asesoria.pago', compact('asesoria', 'configuracion', 'regiones'));
    }


    public function getTerritorio(string $id)
    {
        $response = Http::get('http://44.212.113.88:8081/api/wompi/regiones');

        if ($response->successful()) {
            $regiones = $response->json();

            // Buscar la región con el id recibido
            $region = collect($regiones)->firstWhere('id', $id);

            if ($region && isset($region['territorios'])) {
                return response()->json($region['territorios']);
            }
        }

        return response()->json([], 404);
    }


    public function pago(Request $request)
    {
        // 1️⃣ Obtener datos del formulario
        $numeroTarjeta   = $request->input('numero_tarjeta');
        $cvv             = $request->input('cvv');
        $fechaExp        = $request->input('fecha_expedicion'); // formato MM/AAAA o MM/YY
        $paisId          = $request->input('pais');
        $territorioId    = $request->input('territorio');

        // Separar mes y año de la fecha de expiración
        if (strpos($fechaExp, '/') !== false) {
            list($mes, $anio) = explode('/', $fechaExp);
            $mes  = intval($mes);
            $anio = intval($anio);
            if ($anio < 100) { // si es YY, convertir a YYYY
                $anio += 2000;
            }
        } else {
            // Default si no viene bien
            $mes  = 1;
            $anio = date('Y');
        }

        // 2️⃣ Llamar a la API de regiones
        $response = Http::get('http://44.212.113.88:8081/api/wompi/regiones');
        $regiones = $response->json();

        // 3️⃣ Buscar el país y territorio seleccionados
        $paisNombre = null;
        $territorioNombre = null;

        foreach ($regiones as $region) {
            if ($region['id'] === $paisId) {
                $paisNombre = $region['nombre'];

                foreach ($region['territorios'] as $territorio) {
                    if ($territorio['id'] === $territorioId) {
                        $territorioNombre = $territorio['nombre'];
                        break 2; // salir de ambos foreach
                    }
                }
            }
        }



        $configuracion = Configuracion::first();


        // 4️⃣ Armar JSON final
        $body = [
            "tarjetaCreditoDebido" => [
                "numeroTarjeta"   => $numeroTarjeta,
                "cvv"             => $cvv,
                "mesVencimiento"  => $mes,
                "anioVencimiento" => $anio
            ],
            "monto"       => $configuracion->costo_asesoria ?? 0.00,
            "urlRedirect" => url('usuario/asesoria/pago_finalizado'),
            "nombre"      => auth()->user()->name,
            "apellido"    => auth()->user()->lastname,
            "email"       => auth()->user()->email,
            "ciudad"      => $territorioNombre ?? 'Desconocida',
            "direccion"   => $territorioNombre ?? 'Desconocida',
            "idPais"      => $paisId,
            "idRegion"    => $territorioId,
            "codigoPostal" => "10101",
            "telefono" => preg_replace('/\D/', '', auth()->user()->phone),
        ];

        //dd($body);

        //try {
            $response = Http::post('http://44.212.113.88:8081/api/wompi/transaccion/3ds', $body);
            $data = $response->json();

            // Si existe urlCompletarPago3Ds -> redireccionar
            if (isset($data['urlCompletarPago3Ds'])) {
                return redirect()->away($data['urlCompletarPago3Ds']);
            }

            // Si hay error en la transacción
            if (isset($data['servicioError'])) {
                return back()->with('error', implode(', ', $data['mensajes'] ?? ['Error desconocido']));
            }

            // Por seguridad, fallback
            return back()->with('error', 'Error inesperado en la transacción.');
        // } catch (\Exception $e) {
        //     return back()->with('error', 'No se pudo conectar con el servicio de pagos: ' . $e->getMessage());
        // }

    }

    public function pago_finalizado(Request $request)
    {
        return view('usuario.asesoria.pago_finalizado');
    }



    public function agendadas()
    {
        $asesorias = Asesoria::with(['estado', 'modo', 'tipo', 'user'])
            ->where('user_id', auth()->user()->id)
            ->get();

        $data = $asesorias->map(function ($asesoria) {
            return [
                "id"       => $asesoria->id,
                "title"       => "Asesoria",
                "start"       => $asesoria->fecha . ' ' . $asesoria->hora,
                "description" => "Modo: {$asesoria->modo->nombre}, Tipo: {$asesoria->tipo->nombre}",
                "backgroundColor" => "#6da595ff", // fondo azul
                "borderColor"     => "#036554", // borde azul
                "textColor"       => "#ffffff"  // texto blanco
            ];
        })->toArray();


        return view('usuario.asesoria.agendada', compact('data'));
    }

    public function sucursales()
    {
        return view('usuario.sucursales');
    }

    public function destroy(string $id)
    {
        //
    }
}
