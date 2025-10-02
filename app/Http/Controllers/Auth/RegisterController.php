<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    //use RegistersUsers;

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validaciones
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'lastname'  => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:8|confirmed',
            'photo'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'phone'     => 'required|string|max:255',
        ], [
            'name.required'         => 'El nombre es obligatorio.',
            'name.string'           => 'El nombre debe ser un texto válido.',
            'name.max'              => 'El nombre no puede superar los 255 caracteres.',

            'lastname.required'     => 'Los apellidos son obligatorios.',
            'lastname.string'       => 'Los apellidos deben ser un texto válido.',
            'lastname.max'          => 'Los apellidos no pueden superar los 255 caracteres.',

            'email.required'        => 'El correo electrónico es obligatorio.',
            'email.string'          => 'El correo electrónico debe ser un texto válido.',
            'email.email'           => 'El correo electrónico debe tener un formato válido.',
            'email.max'             => 'El correo electrónico no puede superar los 255 caracteres.',
            'email.unique'          => 'El correo electrónico ya está registrado.',

            'password.required'     => 'La contraseña es obligatoria.',
            'password.string'       => 'La contraseña debe ser un texto válido.',
            'password.min'          => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'    => 'Las contraseñas no coinciden.',

            'photo.image'           => 'El archivo debe ser una imagen.',
            'photo.mimes'           => 'La imagen debe ser de tipo: jpg, jpeg o png.',
            'photo.max'             => 'La imagen no debe superar los 2MB.',

            'phone.required'        => 'El número de teléfono es obligatorio.',
            'phone.string'          => 'El número de teléfono debe ser un texto válido.',
            'phone.max'             => 'El número de teléfono no puede superar los 255 caracteres.',
        ]);

        try {
            $user = DB::transaction(function () use ($request, $validated) {
                $filename = null;
                if ($request->hasFile('photo')) {
                    $file     = $request->file('photo');
                    $ext      = $file->getClientOriginalExtension();
                    $filename = uniqid() . '.' . $ext;
                    $file->storeAs('public/photos', $filename);
                }

                $user = new User();
                $user->name     = $validated['name'];
                $user->lastname = $validated['lastname'];
                $user->phone    = $validated['phone'];
                $user->email    = $validated['email'];
                $user->password = Hash::make($validated['password']);
                $user->photo    = $filename;
                $user->active   = 1;
                $user->save();

                return $user;
            });

            $user->assignRole('cliente');

            Auth::login($user);

            return redirect()->route('home')->with('success', 'Usuario registrado y sesión iniciada.');
        } catch (\Exception $e) {
            if (!empty($filename) && Storage::exists('public/photos/' . $filename)) {
                Storage::delete('public/photos/' . $filename);
            }
            return back()->withErrors(['error' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }



    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
