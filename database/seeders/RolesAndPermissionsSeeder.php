<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Crear roles
        Role::firstOrCreate(['name' => 'administrador']);
        Role::firstOrCreate(['name' => 'abogado']);
        Role::firstOrCreate(['name' => 'operador']);

        // Crear un usuario de ejemplo para el administrador
        $user = User::firstOrCreate([
            'email' => 'admin@mail.com'
        ], [
            'name' => 'Admin User',
            'lastname' => 'Admin Lastname',
            'email' => 'admin@mail.com',
            'password' => Hash::make('12345678'),
            'active' => 1
        ]);

        // Asignar el rol de 'administrador' al usuario
        $user->assignRole('administrador');
    }
}
