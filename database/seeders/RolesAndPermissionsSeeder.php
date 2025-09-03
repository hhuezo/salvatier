<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
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
        $adminRole = Role::firstOrCreate(['name' => 'administrador']);
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
        $user->assignRole($adminRole);

        // Crear permiso 'menu_seguridad'
        $menuSeguridad = Permission::firstOrCreate(['name' => 'menu seguridad']);

        // Asignar el permiso al rol administrador
        $adminRole->givePermissionTo($menuSeguridad);
    }
}
