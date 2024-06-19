<?php

namespace App\Http\Controllers;

use App\Models\Doctores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DoctoresController extends Controller
{
    public function index(): View
    {
        $doctores = Doctores::all();
        return view('doctores.doctores', ['doctores' => $doctores]);
    }

    public function edit(Doctores $doctor): View
    {
        return view('doctores.edit', ['doctor' => $doctor]);
    }

    public function create(): View
    {
        return view('doctores.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:doctores'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['required', 'string', 'max:20'],
            'especialidad' => ['required', 'string', 'max:255'],
            'consultorio' => ['required', 'string', 'max:10'],
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

        return redirect()->route('doctores.index')->with('success', 'Nuevo doctor agregado.');
    }

    public function update(Request $request, Doctores $doctor): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:doctores,correo,' . $doctor->id],
            'telefono' => ['required', 'string', 'max:20'],
            'especialidad' => ['required', 'string', 'max:255'],
            'consultorio' => ['required', 'string', 'max:10'],
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
