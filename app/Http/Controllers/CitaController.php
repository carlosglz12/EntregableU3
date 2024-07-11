<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Pacientes;
use App\Models\Doctores;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CitaController extends Controller
{
    // método para mostrar todas las citas
    public function index(): View
    {
        // obtener todas las citas con información del paciente y del doctor, y formatear los datos para el calendario
        $citas = Cita::with('paciente', 'doctor')->get()->map(function ($cita) {
            return [
                'title' => $cita->paciente->nombres . ' ' . $cita->paciente->apellidos, // el título de la cita será el nombre del paciente
                'start' => $cita->fecha . 'T' . $cita->hora, // fecha y hora de inicio de la cita
                'description' => 'Doctor: ' . $cita->doctor->nombres . ' ' . $cita->doctor->apellidos, // descripción de la cita con el nombre del doctor
            ];
        });
        // retornar la vista 'citas.fullcalendar' con la lista de citas
        return view('citas.fullcalendar', ['citas' => $citas]);
    }

    // método para mostrar el formulario de creación de una nueva cita
    public function create(): View
    {
        // obtener todos los pacientes y doctores
        $pacientes = Pacientes::all();
        $doctores = Doctores::all();
        // retornar la vista 'citas.create' con la lista de pacientes y doctores
        return view('citas.create', compact('pacientes', 'doctores'));
    }

    // método para mostrar la tabla de todas las citas
    public function tablacitas(): View
    {
        // obtener todas las citas con información del paciente y del doctor
        $citas = Cita::with('paciente', 'doctor')->get();
        // retornar la vista 'citas.tablacitas' con la lista de citas
        return view('citas.tablacitas', compact('citas'));
    }

    // método para guardar una nueva cita en la base de datos
    public function store(Request $request)
    {
        // validar los datos del formulario
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id', // el paciente debe existir en la tabla de pacientes
            'doctor_id' => 'required|exists:doctores,id', // el doctor debe existir en la tabla de doctores
            'fecha' => 'required|date|after:yesterday', // la fecha debe ser una fecha válida y no puede ser en el pasado
            'hora' => 'required', // la hora es obligatoria
        ]);

        // verificar si ya existe una cita en la misma fecha y hora
        $existingCita = Cita::where('fecha', $request->fecha)->where('hora', $request->hora)->first();

        if ($existingCita) {
            // redirigir de vuelta con un mensaje de error si ya existe una cita en la misma fecha y hora
            return redirect()->back()->withErrors(['fecha_hora' => 'Ya existe una cita programada para esta fecha y hora.']);
        }

        // crear y guardar la nueva cita en la base de datos
        Cita::create([
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => 'en proceso'
        ]);

        // redirigir a la lista de citas con un mensaje de éxito
        return redirect()->route('citas.index')->with('success', 'Cita agendada exitosamente.');
    }

    // método para mostrar el formulario de edición de una cita existente
    public function editar($id): View
    {
        // encontrar la cita por su ID
        $cita = Cita::findOrFail($id);
        // obtener todos los pacientes y doctores
        $pacientes = Pacientes::all();
        $doctores = Doctores::all();
       
        return view('citas.edit', compact('cita', 'pacientes', 'doctores'));
    }

    // método para actualizar una cita existente en la base de datos
    public function update(Request $request, $id)
    {
        // validar los datos del formulario
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id', 
            'fecha' => 'required|date|after:now', // la fecha debe ser una fecha válida y no puede ser en el pasado
            'hora' => 'required', 
            'estado' => 'required|in:completada,terminada,en proceso,cancelada' // el estado debe ser uno de los valores permitidos
        ]);

        // encontrar la cita por su ID
        $cita = Cita::findOrFail($id);
        // verificar si ya existe una cita en la misma fecha y hora (excluyendo la actual)
        $existingCita = Cita::where('fecha', $request->fecha)->where('hora', $request->hora)->where('id', '!=', $id)->first();

        if ($existingCita) {
            // redirigir de vuelta con un mensaje de error si ya existe una cita en la misma fecha y hora
            return redirect()->back()->withErrors(['fecha_hora' => 'Ya existe una cita programada para esta fecha y hora.']);
        }

        // actualizar la cita con los nuevos datos
        $cita->update([
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => $request->estado
        ]);

        // redirigir a la tabla de citas con un mensaje de éxito
        return redirect()->route('citas.tablacitas')->with('success', 'Cita actualizada exitosamente.');
    }

    // método para eliminar una cita de la base de datos
    public function eliminar($id)
    {
        // encontrar la cita por su ID
        $cita = Cita::findOrFail($id);
        // eliminar la cita de la base de datos
        $cita->delete();
        // redirigir a la tabla de citas con un mensaje de éxito
        return redirect()->route('citas.tablacitas')->with('success', 'Cita eliminada exitosamente.');
    }
}
