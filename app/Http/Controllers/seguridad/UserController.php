<?php

namespace App\Http\Controllers\seguridad;

use App\Http\Controllers\Controller;
use App\Models\seguridad\Configuracion;
use App\Models\seguridad\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuarios = User::get();
        $roles = Role::get();
        return view('seguridad.usuario.index', compact('usuarios', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        // Validaciones
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'lastname' => 'required|string|max:50',
                'email' => 'required|string|email|max:50|unique:users,email',
                'password' => 'required|string|min:6',
                'role_id' => 'required|exists:roles,id',
            ],
            [
                // Name
                'name.required' => 'El nombre es obligatorio.',
                'name.string' => 'El nombre debe ser una cadena de texto.',
                'name.max' => 'El nombre no debe superar los 255 caracteres.',

                // Last Name
                'lastname.required' => 'El apellido es obligatorio.',
                'lastname.string' => 'El apellido debe ser una cadena de texto.',
                'lastname.max' => 'El apellido no debe superar los 50 caracteres.',

                // Email
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.string' => 'El correo electrónico debe ser una cadena de texto.',
                'email.email' => 'Debe ingresar un correo electrónico válido.',
                'email.max' => 'El correo electrónico no debe superar los 50 caracteres.',
                'email.unique' => 'Este correo electrónico ya está registrado.',

                // Password
                'password.required' => 'La contraseña es obligatoria.',
                'password.string' => 'La contraseña debe ser una cadena de texto.',
                'password.min' => 'La contraseña debe tener al menos 6 caracteres.',

                // Role
                'role_id.required' => 'El rol es obligatorio.',
                'role_id.exists' => 'El rol seleccionado no existe.',
            ]
        );


        try {
            DB::beginTransaction();

            // Crear usuario
            $user = new User();
            $user->name = $validated['name'];
            $user->lastname = $validated['lastname'];
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->active = 1;
            $user->save();

            // Asignar rol
            $role = Role::findOrFail($validated['role_id']);
            $user->assignRole($role->name);

            DB::commit();

            return redirect()->back()->with('success', 'Usuario creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al crear usuario: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Hubo un error al crear el usuario.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::get();
        return view('seguridad.usuario.edit', compact('usuario', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate(
            [
                'name' => 'required|string|max:255',
                'lastname' => 'required|string|max:50',
                'email' => 'required|string|max:50|unique:users,email,' . $id,
                'role_id' => 'required|exists:roles,id',
            ],
            [
                'name.required' => 'El nombre es obligatorio.',
                'name.string' => 'El nombre debe ser una cadena de texto.',
                'name.max' => 'El nombre no debe superar los 255 caracteres.',

                'lastname.required' => 'El apellido es obligatorio.',
                'lastname.string' => 'El apellido debe ser una cadena de texto.',
                'lastname.max' => 'El apellido no debe superar los 50 caracteres.',

                // Email
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.string' => 'El correo electrónico debe ser una cadena de texto.',
                'email.email' => 'Debe ingresar un correo electrónico válido.',
                'email.max' => 'El correo electrónico no debe superar los 50 caracteres.',
                'email.unique' => 'Este correo electrónico ya está registrado.',

                'role_id.required' => 'El rol es obligatorio.',
                'role_id.exists' => 'El rol seleccionado no existe.',
            ]
        );

        try {

            DB::beginTransaction();
            $user = User::findOrFail($id);
            $user->name = $validated['name'];
            $user->lastname = $validated['lastname'];
            $user->email = $validated['email'];
            $user->save();

            // Asignar rol
            $role = Role::findOrFail($validated['role_id']);
            $user->syncRoles([$role->name]);
            DB::commit();

            return redirect()->back()->with('success', 'Usuario modificado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error al modificar usuario: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all(),
            ]);

            return redirect()->back()->with('error', 'Hubo un error al modificar el usuario.');
        }
    }

    public function destroy(string $id)
    {
        try {
            $usuario = User::findOrFail($id);

            $usuario->active = $usuario->active == 1 ? 0 : 1;
            $usuario->save();

            return response()->json([
                'success' => true,
                'message' => $usuario->active == 1 ? 'Usuario activado' : 'Usuario desactivado',
                'nuevo_estado' => $usuario->active
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updatePassword(Request $request, $id)
    {
        // Validaciones de la contraseña
        $validated = $request->validate([
            'password' => 'required|string|min:6',
        ], [
            'id.required' => 'El usuario no es válido.',
            'id.exists' => 'El usuario no existe en la base de datos.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        try {
            // Buscar al usuario
            $user = User::findOrFail($id);

            // Actualizar la contraseña
            $user->password = Hash::make($request->password);
            $user->save();

            // Retornar con mensaje de éxito
            return back()->with('success', 'La contraseña se ha actualizado correctamente.');
        } catch (\Exception $e) {
            // Si ocurre un error, retornamos con mensaje de error
            return back()->with('error', 'Hubo un error al actualizar la contraseña. Intenta nuevamente.');
        }
    }

    public function configuracion()
    {

        $configuracion = Configuracion::first();
        return view('seguridad.usuario.configuracion', compact('configuracion'));
    }

    public function configuracionStore(Request $request)
    {

        $configuracion = Configuracion::first();
        $configuracion->costo_asesoria = $request->costo_asesoria;
        $configuracion->save();


        // Retornar con mensaje de éxito
        return back()->with('success', 'Registro actualizado correctamente.');
    }
}
