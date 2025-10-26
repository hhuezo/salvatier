<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateUserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole   = Role::firstOrCreate(['name' => 'administrador']);
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
        $user->assignRole($adminRole);
    }
}
