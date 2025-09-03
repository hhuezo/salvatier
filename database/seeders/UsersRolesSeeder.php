<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersRolesSeeder extends Seeder
{
    public function run()
    {
        $rolAbogado = Role::where('id', 1)->first();
        $rolOperador = Role::where('id', 2)->first();

        // 20 Abogados
        $abogados = [
            ['name'=>'Carlos','lastname'=>'Gonzalez','email'=>'carlos.gonzalez@example.com'],
            ['name'=>'María','lastname'=>'Fernandez','email'=>'maria.fernandez@example.com'],
            ['name'=>'Jorge','lastname'=>'Ramirez','email'=>'jorge.ramirez@example.com'],
            ['name'=>'Ana','lastname'=>'Lopez','email'=>'ana.lopez@example.com'],
            ['name'=>'Luis','lastname'=>'Martinez','email'=>'luis.martinez@example.com'],
            ['name'=>'Sofia','lastname'=>'Diaz','email'=>'sofia.diaz@example.com'],
            ['name'=>'Miguel','lastname'=>'Santos','email'=>'miguel.santos@example.com'],
            ['name'=>'Laura','lastname'=>'Torres','email'=>'laura.torres@example.com'],
            ['name'=>'Diego','lastname'=>'Vargas','email'=>'diego.vargas@example.com'],
            ['name'=>'Camila','lastname'=>'Flores','email'=>'camila.flores@example.com'],
            ['name'=>'Pedro','lastname'=>'Rojas','email'=>'pedro.rojas@example.com'],
            ['name'=>'Valeria','lastname'=>'Castro','email'=>'valeria.castro@example.com'],
            ['name'=>'Ricardo','lastname'=>'Mendez','email'=>'ricardo.mendez@example.com'],
            ['name'=>'Isabella','lastname'=>'Herrera','email'=>'isabella.herrera@example.com'],
            ['name'=>'Andrés','lastname'=>'Silva','email'=>'andres.silva@example.com'],
            ['name'=>'Carolina','lastname'=>'Guerra','email'=>'carolina.guerra@example.com'],
            ['name'=>'Fernando','lastname'=>'Navarro','email'=>'fernando.navarro@example.com'],
            ['name'=>'Gabriela','lastname'=>'Cruz','email'=>'gabriela.cruz@example.com'],
            ['name'=>'Juan','lastname'=>'Ramos','email'=>'juan.ramos@example.com'],
            ['name'=>'Paula','lastname'=>'Ortiz','email'=>'paula.ortiz@example.com'],
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

        // 20 Operadores
        $operadores = [
            ['name'=>'Diego','lastname'=>'Lopez','email'=>'diego.lopez@example.com'],
            ['name'=>'Carla','lastname'=>'Gomez','email'=>'carla.gomez@example.com'],
            ['name'=>'Esteban','lastname'=>'Martinez','email'=>'esteban.martinez@example.com'],
            ['name'=>'Fernanda','lastname'=>'Diaz','email'=>'fernanda.diaz@example.com'],
            ['name'=>'Alberto','lastname'=>'Ramirez','email'=>'alberto.ramirez@example.com'],
            ['name'=>'Natalia','lastname'=>'Santos','email'=>'natalia.santos@example.com'],
            ['name'=>'Javier','lastname'=>'Torres','email'=>'javier.torres@example.com'],
            ['name'=>'Adriana','lastname'=>'Vargas','email'=>'adriana.vargas@example.com'],
            ['name'=>'Santiago','lastname'=>'Flores','email'=>'santiago.flores@example.com'],
            ['name'=>'Camila','lastname'=>'Rojas','email'=>'camila.rojas@example.com'],
            ['name'=>'Pablo','lastname'=>'Castro','email'=>'pablo.castro@example.com'],
            ['name'=>'Daniela','lastname'=>'Mendez','email'=>'daniela.mendez@example.com'],
            ['name'=>'Ricardo','lastname'=>'Herrera','email'=>'ricardo.herrera@example.com'],
            ['name'=>'Isabel','lastname'=>'Silva','email'=>'isabel.silva@example.com'],
            ['name'=>'Andrés','lastname'=>'Guerra','email'=>'andres.guerra@example.com'],
            ['name'=>'Carolina','lastname'=>'Navarro','email'=>'carolina.navarro@example.com'],
            ['name'=>'Fernando','lastname'=>'Cruz','email'=>'fernando.cruz@example.com'],
            ['name'=>'Gabriela','lastname'=>'Ramos','email'=>'gabriela.ramos@example.com'],
            ['name'=>'Juan','lastname'=>'Ortiz','email'=>'juan.ortiz@example.com'],
            ['name'=>'Paula','lastname'=>'Perez','email'=>'paula.perez@example.com'],
        ];

        foreach ($operadores as $item) {
            $user = User::create([
                'name' => $item['name'],
                'lastname' => $item['lastname'],
                'email' => $item['email'],
                'password' => Hash::make('password123'),
                'active' => 1,
            ]);
            $user->assignRole($rolOperador);
        }
    }
}
