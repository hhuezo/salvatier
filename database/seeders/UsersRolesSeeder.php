<?php

namespace Database\Seeders;

use App\Models\administracion\Asesoria;
use App\Models\administracion\AsesoriaHistorial;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersRolesSeeder extends Seeder
{
    public function run()
    {
        $rolAbogado = Role::where('id', 2)->first();
        $rolOperador = Role::where('id', 3)->first();

        // 20 Abogados
        $abogados = [
            ['name' => 'Carlos', 'lastname' => 'Gonzalez', 'email' => 'carlos.gonzalez@example.com'],
            ['name' => 'María', 'lastname' => 'Fernandez', 'email' => 'maria.fernandez@example.com'],
            ['name' => 'Jorge', 'lastname' => 'Ramirez', 'email' => 'jorge.ramirez@example.com'],
            ['name' => 'Ana', 'lastname' => 'Lopez', 'email' => 'ana.lopez@example.com'],
            ['name' => 'Luis', 'lastname' => 'Martinez', 'email' => 'luis.martinez@example.com'],
            ['name' => 'Sofia', 'lastname' => 'Diaz', 'email' => 'sofia.diaz@example.com'],
            ['name' => 'Miguel', 'lastname' => 'Santos', 'email' => 'miguel.santos@example.com'],
            ['name' => 'Laura', 'lastname' => 'Torres', 'email' => 'laura.torres@example.com'],
            ['name' => 'Diego', 'lastname' => 'Vargas', 'email' => 'diego.vargas@example.com'],
            ['name' => 'Camila', 'lastname' => 'Flores', 'email' => 'camila.flores@example.com'],
            ['name' => 'Pedro', 'lastname' => 'Rojas', 'email' => 'pedro.rojas@example.com'],
            ['name' => 'Valeria', 'lastname' => 'Castro', 'email' => 'valeria.castro@example.com'],
            ['name' => 'Ricardo', 'lastname' => 'Mendez', 'email' => 'ricardo.mendez@example.com'],
            ['name' => 'Isabella', 'lastname' => 'Herrera', 'email' => 'isabella.herrera@example.com'],
            ['name' => 'Andrés', 'lastname' => 'Silva', 'email' => 'andres.silva@example.com'],
            ['name' => 'Carolina', 'lastname' => 'Guerra', 'email' => 'carolina.guerra@example.com'],
            ['name' => 'Fernando', 'lastname' => 'Navarro', 'email' => 'fernando.navarro@example.com'],
            ['name' => 'Gabriela', 'lastname' => 'Cruz', 'email' => 'gabriela.cruz@example.com'],
            ['name' => 'Juan', 'lastname' => 'Ramos', 'email' => 'juan.ramos@example.com'],
            ['name' => 'Paula', 'lastname' => 'Ortiz', 'email' => 'paula.ortiz@example.com'],
        ];

        foreach ($abogados as $item) {
            $user = User::create([
                'name' => $item['name'],
                'lastname' => $item['lastname'],
                'email' => $item['email'],
                'password' => Hash::make('password123'),
                'active' => 1,
            ]);
            $user->assignRole($rolAbogado);
        }


        DB::table('estado_asesoria')->insert([
            ['nombre' => 'Pendiente', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Pagada', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Confirmada', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Reagendada', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Finalizada', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // DB::table('modo_asesoria')->insert([
        //     ['nombre' => 'Presencial', 'costo' => 0.01, 'created_at' => now(), 'updated_at' => now()],
        //     ['nombre' => 'Virtual', 'costo' => 0.02, 'created_at' => now(), 'updated_at' => now()],
        //     ['nombre' => 'Empresarial', 'costo' => 0.03, 'created_at' => now(), 'updated_at' => now()],
        // ]);

          DB::table('estado_servicio')->insert([
            ['nombre' => 'Registrada'], ['nombre' => 'Finalizada'], ['nombre' => 'Anulada'],
        ]);


        DB::table('tipo_asesoria')->insert([
            ['nombre' => 'Legal', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // $descripciones = [
        //     'Asesoría sobre contrato de arrendamiento.',
        //     'Consulta sobre derechos laborales.',
        //     'Orientación en proceso de divorcio.',
        //     'Asesoría sobre herencia y testamentos.',
        //     'Consulta sobre impuestos y tributos.',
        //     'Asesoría en compra-venta de inmuebles.',
        //     'Consulta sobre constitución de sociedad.',
        //     'Asesoría en derecho mercantil.',
        //     'Consulta sobre acoso laboral.',
        //     'Asesoría en derecho penal.',
        //     'Orientación en adopción.',
        //     'Consulta sobre pensiones alimenticias.',
        //     'Asesoría en propiedad intelectual.',
        //     'Consulta sobre accidentes de tránsito.',
        //     'Orientación en contratos de servicios.'
        // ];

        // for ($i = 0; $i < 15; $i++) {
        //     // Crear la asesoria principal
        //     $asesoria = new Asesoria();
        //     $asesoria->descripcion = $descripciones[$i];
        //     $asesoria->fecha = Carbon::now()->subDays(rand(0, 30))->toDateString();
        //     $asesoria->hora = Carbon::createFromTime(rand(8, 18), rand(0, 59))->toTimeString();
        //     $asesoria->estado_asesoria_id = rand(1, 5);
        //     $asesoria->modo_asesoria_id = rand(1, 2);
        //     $asesoria->tipo_asesoria_id = 1; // Legal
        //     $asesoria->user_id = rand(22, 40);
        //     //$asesoria->abogado_asignado_id = rand(2, 21);
        //     $asesoria->save();

        //     // Crear el historial copiando los datos
        //     $historial = new AsesoriaHistorial();
        //     $historial->descripcion = $asesoria->descripcion;
        //     $historial->fecha = $asesoria->fecha;
        //     $historial->hora = $asesoria->hora;
        //     $historial->enlace = null; // si no tienes dato inicial
        //     $historial->asesoria_id = $asesoria->id;
        //     $historial->estado_asesoria_id = $asesoria->estado_asesoria_id;
        //     $historial->tipo_asesoria_id = $asesoria->tipo_asesoria_id;
        //     $historial->modo_asesoria_id = $asesoria->modo_asesoria_id;
        //     $historial->user_id = $asesoria->user_id;
        //     //$historial->abogado_asignado_id = $asesoria->abogado_asignado_id;
        //     $historial->save();
        // }


        //notificaciones
       /* $mensajes = [
            "Su asesoría programada ha sido confirmada.",
            "Tiene una nueva notificación pendiente de revisión.",
            "Se ha generado un reporte de su última asesoría.",
            "Recuerde que la asesoría está próxima a iniciar.",
            "El documento solicitado ya está disponible para descarga.",
            "Se detectó un retraso en la sesión, verifique con el asesor.",
            "Actualización de estado: su asesoría ha sido finalizada.",
            "Su sesión virtual está lista, revise el enlace de acceso.",
            "Ha recibido un nuevo comentario en la asesoría.",
            "Su solicitud ha sido reagendada exitosamente.",
            "Notificación importante: verifique la criticidad asignada.",
            "Un archivo adicional ha sido adjuntado a su asesoría.",
            "Se requiere su confirmación para la próxima asesoría.",
            "El sistema detectó cambios en la programación.",
            "Su cuenta ha recibido una nueva notificación administrativa."
        ];

        $notificaciones = [];

        foreach ($mensajes as $i => $mensaje) {
            $notificaciones[] = [
                'user_id' => rand(22, 40),
                'mensaje' => $mensaje,
                'archivo' => "documento{$i}.pdf",
                'criticidad' => rand(1, 3), // 1 = baja, 2 = media, 3 = alta
                'activo' => 1,
                'fecha' => now()->subDays(rand(0, 30)), // fecha aleatoria dentro del último mes
                'created_at' => now()->subDays(rand(0, 30)),
                'updated_at' => now()->subDays(rand(0, 30)),
            ];
        }

        DB::table('notificacion')->insert($notificaciones);*/
    }
}
