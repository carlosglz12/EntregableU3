<?php

namespace App\Http\Controllers;

use App\Models\Doctores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; 

class DoctoresController extends Controller
{
    // Mostrar vista register cuando se de clic en crear 
    public function index(): View
    {
        $doctores = Doctores::all();
        return view('doctores.doctores', ['doctores' => $doctores]);
    }

    // Método para mostrar el formulario para editar a los doctores
    public function edit(Doctores $doctor): View
    {
        return view('doctores.edit', ['doctor' => $doctor]);
    }
    
    // Formulario de crear doctor
    public function create(): View
    {
        return view('doctores.create');
    }

    // Método para crear el doctor
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:doctores'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['required', 'int'],
            'especialidad' => ['required', 'string', 'max:255'],
            'consultorio' => ['required', 'int'],
        ]);

        $doctor = Doctores::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono, 
            'especialidad' => $request->especialidad,
            'consultorio' => $request->consultorio,
        ]);

        event(new Registered($doctor));

        return redirect()->route('doctores.index')->with('success', 'Nuevo doctor agregado.');
    }

    // Método para actualizar los datos del doctor
    public function update(Request $request, Doctores $doctor): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:doctores,correo,' . $doctor->id],
            'telefono' => ['required', 'int'],
            'especialidad' => ['required', 'string', 'max:255'],
            'consultorio' => ['required', 'int'],
        ]);

        $doctor->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'especialidad' => $request->especialidad,
            'consultorio' => $request->consultorio,
        ]);

        return redirect()->route('doctores.index')->with('success', 'Datos del doctor actualizados.');
    }

    // Método para eliminar el doctor
    public function destroy($id): RedirectResponse
    {
        $doctor = Doctores::find($id);
        if ($doctor) {
            $doctor->delete();
            return redirect()->route('doctores.index')->with('success', 'Doctor eliminado exitosamente.');
        }
        return redirect()->route('doctores.index')->with('error', 'Doctor no encontrado.');
    }
}

?>
