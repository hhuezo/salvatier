<?php

namespace App\Http\Controllers\usuario;

use App\Http\Controllers\Controller;
use App\Models\administracion\Asesoria;
use App\Models\administracion\AsesoriaHistorial;
use App\Models\administracion\ModoAsesoria;
use App\Models\administracion\Notificacion;
use App\Models\administracion\TipoAsesoria;
use App\Models\seguridad\Configuracion;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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

        // Consumir API de regiones
        $response = Http::get('http://44.212.113.88:8081/api/wompi/regiones');

        $regiones = [];
        if ($response->successful()) {
            $regiones = $response->json();
        }

        return view('usuario.asesoria.pago', compact('asesoria', 'regiones'));
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

        $asesoria = Asesoria::findOrFail($id);


        // 4️⃣ Armar JSON final
        $body = [
            "tarjetaCreditoDebido" => [
                "numeroTarjeta" => str_replace(' ', '', $numeroTarjeta),
                "cvv"             => $cvv,
                "mesVencimiento"  => $mes,
                "anioVencimiento" => $anio
            ],
            "monto"       => $asesoria->modo->costo ?? 0.00,
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

        try {

            $asesoria = Asesoria::findOrFail($id);

            $response = Http::post('http://44.212.113.88:8081/api/wompi/transaccion/3ds', $body);
            $data = $response->json();

            // Si existe urlCompletarPago3Ds -> redireccionar
            if (isset($data['urlCompletarPago3Ds'])) {

                //guardar registro de pago
                $asesoria->costo_asesoria = $asesoria->modo->costo ?? 0.00;
                $asesoria->estado_asesoria_id = 2;
                $asesoria->fecha_pago = Carbon::now();
                $asesoria->id_trasaccion = $data['idTransaccion'] ?? null;
                $asesoria->save();

                return redirect()->away($data['urlCompletarPago3Ds']);
            }

            // Si hay error en la transacción
            if (isset($data['servicioError'])) {
                $errorMessage = implode(', ', $data['mensajes'] ?? ['Error desconocido en el servicio']);

                return back()->withErrors(['servicio_general' => $errorMessage]);
            }

            // Por seguridad, fallback
            return back()->with('error', 'Error inesperado en la transacción.');
        } catch (\Exception $e) {
            return back()->with('error', 'No se pudo conectar con el servicio de pagos: ' . $e->getMessage());
        }
    }

    public function pago_finalizado(Request $request)
    {
        try {
            $asesoria = Asesoria::where('id_trasaccion', $request->idTransaccion)->first();

            if (!$asesoria) {
                // Opcional: redirigir o mostrar mensaje si no existe
                return redirect()->back()->with('error', 'No se encontró la transacción.');
            }

            // ===== Envío de correo =====
            $emailDestino = $asesoria->user->email ?? null;
            $nombreCliente = trim(($asesoria->user->name ?? '') . ' ' . ($asesoria->user->lastname ?? '')) ?: 'Cliente';

            // Asegurar que la configuración regional esté en español
            Carbon::setLocale('es');

            // Combinar fecha y hora
            $fechaCompleta = Carbon::parse("{$asesoria->fecha} {$asesoria->hora}");

            // Ejemplo: "Lunes 21 de octubre de 2025 a las 10:30 a.m."
            $fechaFormateada = $fechaCompleta->translatedFormat('l j \\d\\e F \\d\\e Y \\a \\l\\a\\s g:i a');

            if ($emailDestino) {
                try {
                    Mail::send('emails.confirmacion_cita', ['cliente' => $nombreCliente, 'fecha' => $fechaFormateada], function ($message) use ($emailDestino) {
                        $message->to($emailDestino)
                            ->subject('📅 Confirmación pendiente de cita agendada');
                    });
                } catch (Exception $e) {
                    Log::error("Fallo al enviar el correo de notificación: " . $e->getMessage());
                }
            } else {
                Log::warning("No se envió correo: la asesoría no tiene un usuario con email válido.");
            }

            return view('usuario.asesoria.pago_finalizado', compact('asesoria'));
        } catch (\Exception $e) {
            // Manejo de error: log y redirección
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
