<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use Illuminate\Http\Request;

class PacientesController extends Controller
{
    public function index()
    {
        $pacientes = Pacientes::all();
        return view('pacientes.pacientes', compact('pacientes'));
    }

    public function create()
    {
        return view('pacientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:pacientes'],
            'telefono' => ['required', 'integer'],
            'telefono_emergencia' => ['required', 'integer'],
            'genero' => ['required', 'string'],
            'fecha_nacimiento' => ['required', 'date'],
            'notas' => ['nullable', 'string'],
        ]);

        Pacientes::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'telefono_emergencia' => $request->telefono_emergencia,
            'genero' => $request->genero,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'notas' => $request->notas,
        ]);

        return redirect()->route('pacientes.index')->with('success', 'Paciente creado con éxito.');
    }

    public function edit(Pacientes $paciente)
    {
        return view('pacientes.edit', compact('paciente'));
    }

    public function update(Request $request, Pacientes $paciente)
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:pacientes'],
            'telefono' => ['required', 'integer'],
            'telefono_emergencia' => ['required', 'integer'],
            'genero' => ['required', 'string'],
            'fecha_nacimiento' => ['required', 'date'],
            'notas' => ['nullable', 'string'],
        ]);

        $paciente->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
            'telefono_emergencia' => $request->telefono_emergencia,
            'genero' => $request->genero,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'notas' => $request->notas,
        ]);

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado con éxito.');
    }

    public function destroy(Pacientes $paciente)
    {
        $paciente->delete();
        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado con éxito.');
    }
}
