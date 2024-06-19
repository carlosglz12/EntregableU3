<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Doctores;
use App\Models\Pacientes; // Cambiado de Paciente a Pacientes
use App\Models\Secretaria;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'in:medico,secretaria,paciente'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Guardar en la tabla correspondiente según el rol
        switch ($request->role) {
            case 'medico':
                Doctores::create([
                    'nombres' => $request->name,
                    'apellidos' => $request->last_name,
                    'correo' => $request->email,
                    'password' => Hash::make($request->password),
                    'telefono' => 0, // Asignar valor adecuado
                    'especialidad' => '', // Asignar valor adecuado
                    'consultorio' => 0, // Asignar valor adecuado
                ]);
                break;
            case 'secretaria':
                Secretaria::create([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'phone' => 0, // Asignar valor adecuado
                ]);
                break;
            case 'paciente':
                Pacientes::create([ // Cambiado de Paciente a Pacientes
                    'nombres' => $request->name,
                    'apellidos' => $request->last_name,
                    'correo' => $request->email,
                    'password' => Hash::make($request->password),
                    'telefono' => 0, // Asignar valor adecuado
                    'direccion' => '', // Asignar valor adecuado
                    'edad' => 0, // Asignar valor adecuado
                ]);
                break;
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
