<?php

namespace App\Http\Controllers;

use App\Models\Doctores;
use App\Models\User;
use App\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DoctoresController extends Controller
{
    // Método para mostrar todos los doctores
    public function index(): View
    {
        // Obtener todos los doctores de la base de datos
        $doctores = Doctores::all();
        // Retornar la vista 'doctores.doctores' con la lista de doctores
        return view('doctores.doctores', ['doctores' => $doctores]);
    }

    // Método para mostrar el formulario de edición de un doctor
    public function edit(Doctores $doctor): View
    {
        // Retornar la vista 'doctores.edit' con la información del doctor
        return view('doctores.edit', ['doctor' => $doctor]);
    }

    // Método para mostrar el formulario de creación de un nuevo doctor
    public function create(): View
    {
        // Retornar la vista 'doctores.create'
        return view('doctores.create');
    }

    // Método para guardar un nuevo doctor en la base de datos
    public function store(Request $request): RedirectResponse
    {
        // Validar los datos del formulario
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:doctores'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['required', 'string', 'max:20'],
            'especialidad' => ['required', 'string', 'max:255'],
            'consultorio' => ['required', 'string', 'max:10'],
        ]);

        // Crear y guardar el nuevo doctor en la base de datos
        $doctor = Doctores::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'especialidad' => $request->especialidad,
            'consultorio' => $request->consultorio,
        ]);

        // Crear y guardar el nuevo usuario en la tabla users
        User::create([
            'name' => $doctor->nombres . ' ' . $doctor->apellidos,
            'email' => $doctor->correo,
            'password' => Hash::make($request->password),
            'role_id' => Role::where('name', 'Doctor')->first()->id,
        ]);

        // Redirigir a la lista de doctores con un mensaje de éxito
        return redirect()->route('doctores.index')->with('success', 'Nuevo doctor agregado.');
    }

    // Método para actualizar la información de un doctor existente
    public function update(Request $request, Doctores $doctor): RedirectResponse
    {
        // Validar los datos del formulario
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:doctores,correo,' . $doctor->id],
            'telefono' => ['required', 'string', 'max:20'],
            'especialidad' => ['required', 'string', 'max:255'],
            'consultorio' => ['required', 'string', 'max:10'],
        ]);

        // Actualizar la información del doctor en la base de datos
        $doctor->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'especialidad' => $request->especialidad,
            'consultorio' => $request->consultorio,
        ]);

        // Redirigir a la lista de doctores con un mensaje de éxito
        return redirect()->route('doctores.index')->with('success', 'Datos del doctor actualizados.');
    }

    public function destroy($id): RedirectResponse
    {
        $doctor = Doctores::find($id);
        if ($doctor) {
            $user = User::where('email', $doctor->correo)->first();
            $doctor->delete();
            if ($user) {
                $user->delete();
            }
            return redirect()->route('doctores.index')->with('success', 'Doctor eliminado exitosamente.');
        }
        return redirect()->route('doctores.index')->with('error', 'Doctor no encontrado.');
    }
    
}
