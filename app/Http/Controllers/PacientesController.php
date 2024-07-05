<?php

namespace App\Http\Controllers;

use App\Models\Pacientes;
use Illuminate\Http\Request;

class PacientesController extends Controller
{
    // Método para mostrar todos los pacientes
    public function index()
    {
        // Obtener todos los pacientes de la base de datos
        $pacientes = Pacientes::all();
        // Retornar la vista 'pacientes.pacientes' con la lista de pacientes
        return view('pacientes.pacientes', compact('pacientes'));
    }

    // Método para mostrar el formulario de creación de un nuevo paciente
    public function create()
    {
        // Retornar la vista 'pacientes.create'
        return view('pacientes.create');
    }

    // Método para guardar un nuevo paciente en la base de datos
    public function store(Request $request)
    {
        // Validar los datos del formulario
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

        // Crear y guardar el nuevo paciente en la base de datos
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

        // Redirigir a la lista de pacientes con un mensaje de éxito
        return redirect()->route('pacientes.index')->with('success', 'Paciente creado con éxito.');
    }

    // Método para mostrar el formulario de edición de un paciente
    public function edit(Pacientes $paciente)
    {
        // Retornar la vista 'pacientes.edit' con la información del paciente
        return view('pacientes.edit', compact('paciente'));
    }

    // Método para actualizar la información de un paciente existente
    public function update(Request $request, Pacientes $paciente)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'email', 'max:255', 'unique:pacientes,correo,' . $paciente->id],
            'telefono' => ['required', 'integer'],
            'telefono_emergencia' => ['required', 'integer'],
            'genero' => ['required', 'string'],
            'fecha_nacimiento' => ['required', 'date'],
            'notas' => ['nullable', 'string'],
        ]);

        // Actualizar la información del paciente en la base de datos
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

        // Redirigir a la lista de pacientes con un mensaje de éxito
        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado con éxito.');
    }

    // Método para eliminar un paciente de la base de datos
    public function destroy(Pacientes $paciente)
    {
        // Eliminar el paciente de la base de datos
        $paciente->delete();
        // Redirigir a la lista de pacientes con un mensaje de éxito
        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado con éxito.');
    }
}
