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
        $adminRole   = Role::firstOrCreate(['name' => 'administrador']);
        $abogadoRole = Role::firstOrCreate(['name' => 'abogado']);
        $operadorRole = Role::firstOrCreate(['name' => 'operador']);
        $clienteRole = Role::firstOrCreate(['name' => 'cliente']);

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

        $permissions = [
            'menu seguridad',
            'menu administracion',
            'menu permisos',
            'menu usuarios',
            'menu roles',
            'menu abogados',
            'menu operadores',
            'menu gestionar asesorias',
            'menu gestion de pagos',
            'menu notificaciones',
            'menu gestionar de contenido',

            'menu sucursales',
            'menu inicio',
            'menu mis asesorias',
            'menu pagos',
            'dashboard',
            'inicio cliente',
            'confirmar asesoria',
            'reagendar asesoria',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // Asignar permisos a cada rol
        $adminRole->syncPermissions([
            'menu seguridad',
            'menu administracion',
            'menu permisos',
            'menu usuarios',
            'menu roles',
            'menu abogados',
            'menu operadores',
            'menu gestionar asesorias',
            'menu gestion de pagos',
            'menu notificaciones',
            'menu gestionar de contenido',
            'dashboard',
            'confirmar asesoria',
            'reagendar asesoria',
        ]);

        $abogadoRole->syncPermissions([
            'menu abogados',
            'menu operadores',
            'menu gestionar asesorias',
            'menu gestion de pagos',
            'menu notificaciones',
            'menu gestionar de contenido',
            'dashboard',
        ]);

        $operadorRole->syncPermissions([
            'menu abogados',
            'menu operadores',
            'menu gestionar asesorias',
            'menu gestion de pagos',
            'menu notificaciones',
            'menu gestionar de contenido',
            'dashboard',
        ]);

        $clienteRole->syncPermissions([
            'menu sucursales',
            'menu inicio',
            'menu mis asesorias',
            'menu pagos',
            'inicio cliente',
        ]);
    }
}
