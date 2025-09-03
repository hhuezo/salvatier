<?php

namespace App\Http\Controllers\administracion;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OperadorController extends Controller
{
    public function index()
    {
        $operadores = User::whereHas('roles', function ($q) {
            $q->where('id', 3);
        })->get();

        return view('administracion.operador.index', compact('operadores'));
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
        // Validaciones con mensajes personalizados
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'lastname.required' => 'Los apellidos son obligatorios.',
            'lastname.max' => 'Los apellidos no pueden tener más de 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        DB::beginTransaction();

        try {
            // Crear el nuevo usuario
            $user = new User();
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->active = 1;
            $user->save();

            // Asignar rol usando Laravel Permission
            $user->assignRole('operador');

            DB::commit();

            return redirect()->back()->with('success', 'Operador creado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack(); // deshacer cambios si hay error
            return redirect()->back()->with('error', 'Ocurrió un error al crear el operador: ' . $e->getMessage());
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
        //
    }

    public function update(Request $request, $id)
    {
        // Validaciones con mensajes personalizados
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'active' => 'required|in:0,1',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'lastname.required' => 'Los apellidos son obligatorios.',
            'lastname.max' => 'Los apellidos no pueden tener más de 255 caracteres.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
            'active.required' => 'El estado es obligatorio.',
            'active.in' => 'El estado seleccionado no es válido.',
        ]);

        DB::beginTransaction();

        try {
            // Buscar el usuario
            $user = User::findOrFail($id);

            // Actualizar datos
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->active = $request->active;

            // Actualizar contraseña solo si se ingresó
            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // Asegurarse de que tenga el rol de abogado
            if (!$user->hasRole('operador')) {
                $user->syncRoles('operador');
            }

            DB::commit();

            return redirect()->back()->with('success', 'Operador actualizado correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Ocurrió un error al actualizar el operador: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
