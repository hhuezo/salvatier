<?php

namespace App\Http\Controllers\usuario;

use App\Http\Controllers\Controller;
use App\Models\administracion\Asesoria;
use App\Models\administracion\AsesoriaHistorial;
use App\Models\administracion\ModoAsesoria;
use App\Models\administracion\Notificacion;
use App\Models\administracion\TipoAsesoria;
use App\Models\Configuracion;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AsesoriaUsuarioController extends Controller
{

    public function index()
    {
        $asesorias = Asesoria::with(['estado', 'modo', 'tipo', 'user'])->where('user_id', auth()->user()->id)->get();
        $tipos = TipoAsesoria::get();
        $modos = ModoAsesoria::where('activo', 1)->get();

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

            return redirect('usuario/asesoria/' . $asesoria->id)->with('success', 'La asesoría ha sido programada exitosamente');
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

        // Obtener configuración del backend desde la base de datos
        $configuracion = Configuracion::first();

        if (!$configuracion || empty($configuracion->detalle)) {
            Log::error('❌ No se encontró la configuración de API backend en la base de datos.');
            return redirect()->back()->with('error', 'No se pudo obtener la configuración del servicio.');
        }

        $endpoint = rtrim($configuracion->detalle, '/') . '/wompi/regiones';

        // Consumir API de regiones
        try {
            $response = Http::get($endpoint);

            $regiones = $response->successful() ? $response->json() : [];
            if (!$response->successful()) {
                Log::error('⚠️ Error al consumir API de regiones.', [
                    'status' => $response->status(),
                    'endpoint' => $endpoint
                ]);
            }
        } catch (\Exception $e) {
            Log::error('⚠️ Excepción al conectar con API de regiones: ' . $e->getMessage());
            $regiones = [];
        }

        return view('usuario.asesoria.pago', compact('asesoria', 'regiones'));
    }



    public function getTerritorio(string $id)
    {
        // Obtener configuración del backend desde la base de datos
        $configuracion = Configuracion::first();

        if (!$configuracion || empty($configuracion->detalle)) {
            Log::error('❌ No se encontró la configuración de API backend en la base de datos.');
            return response()->json(['error' => 'No se pudo obtener la configuración del servicio.'], 500);
        }

        // Construir endpoint completo
        $endpoint = rtrim($configuracion->detalle, '/') . '/wompi/regiones';

        try {
            // Consumir API de regiones
            $response = Http::get($endpoint);

            if ($response->successful()) {
                $regiones = $response->json();

                // Buscar la región con el ID recibido
                $region = collect($regiones)->firstWhere('id', $id);

                if ($region && isset($region['territorios'])) {
                    return response()->json($region['territorios']);
                }
            } else {
                Log::error('⚠️ Error al consumir API de regiones.', [
                    'status' => $response->status(),
                    'endpoint' => $endpoint
                ]);
            }
        } catch (\Exception $e) {
            Log::error('⚠️ Excepción al conectar con API de regiones: ' . $e->getMessage());
        }

        // Si algo falla, devolver vacío con 404
        return response()->json([], 404);
    }



    public function pago(Request $request, $id)
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
            $mes  = 1;
            $anio = date('Y');
        }

        // 2️⃣ Obtener configuración del backend desde la base de datos
        $configuracion = Configuracion::first();

        if (!$configuracion || empty($configuracion->detalle)) {
            Log::error('❌ No se encontró la configuración de API backend en la base de datos.');
            return back()->with('error', 'No se pudo obtener la configuración del servicio de pago.');
        }

        $baseUrl = rtrim($configuracion->detalle, '/');

        // 3️⃣ Consumir API de regiones
        try {
            $response = Http::get($baseUrl . '/wompi/regiones');
            $regiones = $response->successful() ? $response->json() : [];

            if (!$response->successful()) {
                Log::error('⚠️ Error al consumir API de regiones.', [
                    'status' => $response->status(),
                    'endpoint' => $baseUrl . '/wompi/regiones'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('⚠️ Excepción al conectar con API de regiones: ' . $e->getMessage());
            $regiones = [];
        }

        // 4️⃣ Buscar el país y territorio seleccionados
        $paisNombre = null;
        $territorioNombre = null;

        foreach ($regiones as $region) {
            if ($region['id'] === $paisId) {
                $paisNombre = $region['nombre'];
                foreach ($region['territorios'] as $territorio) {
                    if ($territorio['id'] === $territorioId) {
                        $territorioNombre = $territorio['nombre'];
                        break 2;
                    }
                }
            }
        }

        $asesoria = Asesoria::findOrFail($id);

        // 5️⃣ Armar JSON final para la transacción
        $body = [
            "tarjetaCreditoDebido" => [
                "numeroTarjeta"    => str_replace(' ', '', $numeroTarjeta),
                "cvv"              => $cvv,
                "mesVencimiento"   => $mes,
                "anioVencimiento"  => $anio
            ],
            "monto"        => $asesoria->modo->costo ?? 0.00,
            "urlRedirect"  => url('usuario/asesoria/pago_finalizado'),
            "nombre"       => auth()->user()->name,
            "apellido"     => auth()->user()->lastname,
            "email"        => auth()->user()->email,
            "ciudad"       => $territorioNombre ?? 'Desconocida',
            "direccion"    => $territorioNombre ?? 'Desconocida',
            "idPais"       => $paisId,
            "idRegion"     => $territorioId,
            "codigoPostal" => "10101",
            "telefono"     => preg_replace('/\D/', '', auth()->user()->phone),
        ];

        // 6️⃣ Enviar transacción a la API de Wompi
        try {
            $response = Http::post($baseUrl . '/wompi/transaccion/3ds', $body);
            $data = $response->json();

            if (isset($data['urlCompletarPago3Ds'])) {
                // Guardar registro de pago
                $asesoria->update([
                    'costo_asesoria'     => $asesoria->modo->costo ?? 0.00,
                    'estado_asesoria_id' => 2,
                    'fecha_pago'         => Carbon::now(),
                    'id_trasaccion'      => $data['idTransaccion'] ?? null,
                ]);

                return redirect()->away($data['urlCompletarPago3Ds']);
            }

            // Si hay error en la transacción
            if (isset($data['servicioError'])) {
                $errorMessage = implode(', ', $data['mensajes'] ?? ['Error desconocido en el servicio']);
                return back()->withErrors(['servicio_general' => $errorMessage]);
            }

            // Fallback
            return back()->with('error', 'Error inesperado en la transacción.');
        } catch (\Exception $e) {
            Log::error('⚠️ Excepción al conectar con API de pagos: ' . $e->getMessage());
            return back()->with('error', 'No se pudo conectar con el servicio de pagos: ' . $e->getMessage());
        }
    }


    public function pago_finalizado(Request $request)
    {
        try {
            $asesoria = Asesoria::where('id_trasaccion', $request->idTransaccion)->first();

            if (!$asesoria) {
                return redirect()->back()->with('error', 'No se encontró la transacción.');
            }

            // ===== Datos del usuario =====
            $emailDestino = $asesoria->user->email ?? null;
            $nombreCliente = trim(($asesoria->user->name ?? '') . ' ' . ($asesoria->user->lastname ?? '')) ?: 'Cliente';

            // ===== Fecha formateada =====
            Carbon::setLocale('es');
            $fechaCompleta = Carbon::parse("{$asesoria->fecha} {$asesoria->hora}");
            $fechaFormateada = $fechaCompleta->translatedFormat('l j \\d\\e F \\d\\e Y \\a \\l\\a\\s g:i a');

            // ===== Obtener URL base de la API desde la base de datos =====
            $configuracion = Configuracion::first();

            if (!$configuracion || empty($configuracion->detalle)) {
                Log::error('❌ No se encontró la configuración de API backend en la base de datos.');
                return redirect()->back()->with('error', 'No se pudo obtener la configuración del servicio de correo.');
            }

            $baseUrl = rtrim($configuracion->detalle, '/');

            // ===== Envío de correo vía API Microsoft =====
            if ($emailDestino) {
                $asuntoEmail = '📅 Confirmación pendiente de cita agendada';
                $cuerpoEmail = "Hola {$nombreCliente},\n\n"
                    . "Tu cita ha sido agendada exitosamente para el día {$fechaFormateada}.\n"
                    . "Te enviaremos una notificación de confirmación cuando sea aprobada.\n\n"
                    . "Atentamente,\nEquipo de Asesorías";

                try {
                    $payload = [
                        "to" => $emailDestino,
                        "subject" => $asuntoEmail,
                        "body" => $cuerpoEmail,
                        "attachments" => []
                    ];

                    $response = Http::withHeaders([
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                    ])->post($baseUrl . '/microsoft/send-mail', $payload);

                    if ($response->successful()) {
                        Log::info("📨 Correo de confirmación enviado correctamente.", [
                            'destinatario' => $emailDestino,
                            'asunto' => $asuntoEmail,
                        ]);
                    } else {
                        Log::error("❌ Error al enviar correo vía API Microsoft.", [
                            'status' => $response->status(),
                            'respuesta' => $response->body(),
                            'destinatario' => $emailDestino,
                        ]);
                    }
                } catch (\Exception $e) {
                    Log::error("⚠️ Excepción al enviar correo vía API: " . $e->getMessage());
                }
            } else {
                Log::warning("No se envió correo: la asesoría no tiene un usuario con email válido.");
            }

            return view('usuario.asesoria.pago_finalizado', compact('asesoria'));
        } catch (\Exception $e) {
            Log::error('Error al buscar asesoria: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ocurrió un error al procesar el pago.');
        }
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


    public function mis_notificaiones()
    {
        $notificaciones = Notificacion::whereHas('asesoria', function ($query) {
            $query->where('user_id', auth()->id());
        })->orderBy('fecha', 'desc')->get();
        return view('usuario.mis_notificaiones', compact('notificaciones'));
    }

    public function mis_notificaiones_leido($id)
    {
        $notificacion = Notificacion::findOrFail($id);

        // Alternar el valor de 'leido'
        $notificacion->leido = !$notificacion->leido;
        $notificacion->save();

        return response()->json([
            'success' => true,
            'leido' => $notificacion->leido
        ]);
    }
}
