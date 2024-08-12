<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Pacientes;
use App\Models\Doctores;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CitaController extends Controller
{
    // Método para mostrar todas las citas
    public function index(): View
    {
        // Obtener todas las citas con información del paciente y del doctor, y formatear los datos para el calendario
        $citas = Cita::with('paciente', 'doctor')->get()->map(function ($cita) {
            return [
                'title' => $cita->paciente->nombres . ' ' . $cita->paciente->apellidos, // El título de la cita será el nombre del paciente
                'start' => $cita->fecha . 'T' . $cita->hora, // Fecha y hora de inicio de la cita
                'description' => 'Doctor: ' . $cita->doctor->nombres . ' ' . $cita->doctor->apellidos, // Descripción de la cita con el nombre del doctor
            ];
        });
        // Retornar la vista 'citas.fullcalendar' con la lista de citas
        return view('citas.fullcalendar', ['citas' => $citas]);
    }

    // Método para mostrar el formulario de creación de una nueva cita
    public function create(): View
    {
        // Obtener todos los pacientes y doctores
        $pacientes = Pacientes::all();
        $doctores = Doctores::all();
        // Retornar la vista 'citas.create' con la lista de pacientes y doctores
        return view('citas.create', compact('pacientes', 'doctores'));
    }

    // Método para mostrar la tabla de todas las citas
    public function tablacitas(): View
    {
        // Obtener todas las citas con información del paciente y del doctor
        $citas = Cita::with('paciente', 'doctor')->get();
        // Retornar la vista 'citas.tablacitas' con la lista de citas
        return view('citas.tablacitas', compact('citas'));
    }

    // Método para guardar una nueva cita en la base de datos
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id', 
            'doctor_id' => 'required|exists:doctores,id', 
            'fecha' => 'required|date|after:yesterday', 
            'hora' => 'required', 
        ]);

        // Verificar si ya existe una cita en la misma fecha y hora
        $existingCita = Cita::where('fecha', $request->fecha)
                            ->where('hora', $request->hora)
                            ->where('doctor_id', $request->doctor_id)
                            ->first();

        if ($existingCita) {
            // Redirigir de vuelta con un mensaje de error
            return redirect()->back()->with('error', 'Ya existe una cita programada para esta fecha y hora. Por favor, elige otra.');
        }

        // Crear y guardar la nueva cita en la base de datos
        Cita::create([
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => 'en proceso'
        ]);

        // Redirigir a la lista de citas con un mensaje de éxito
        return redirect()->route('citas.index')->with('success', 'Cita agendada exitosamente.');
    }

    // Método para mostrar el formulario de edición de una cita existente
    public function editar($id): View
    {
        // Encontrar la cita por su ID
        $cita = Cita::findOrFail($id);
        // Obtener todos los pacientes y doctores
        $pacientes = Pacientes::all();
        $doctores = Doctores::all();
       
        return view('citas.edit', compact('cita', 'pacientes', 'doctores'));
    }

    // Método para actualizar una cita existente en la base de datos
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id', 
            'fecha' => 'required|date|after:now', 
            'hora' => 'required', 
            'estado' => 'required|in:completada,terminada,en proceso,cancelada' 
        ]);

        // Encontrar la cita por su ID
        $cita = Cita::findOrFail($id);

        // Verificar si ya existe una cita en la misma fecha y hora (excluyendo la actual)
        $existingCita = Cita::where('fecha', $request->fecha)
                            ->where('hora', $request->hora)
                            ->where('doctor_id', $request->doctor_id)
                            ->where('id', '!=', $id)
                            ->first();

        if ($existingCita) {
            // Redirigir de vuelta con un mensaje de error
            return redirect()->back()->with('error', 'Ya existe una cita programada para esta fecha y hora. Por favor, elige otra.');
        }

        // Actualizar la cita con los nuevos datos
        $cita->update([
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => $request->estado
        ]);

        // Redirigir a la tabla de citas con un mensaje de éxito
        return redirect()->route('citas.tablacitas')->with('success', 'Cita actualizada exitosamente.');
    }

    // Método para eliminar una cita de la base de datos
    public function eliminar($id)
    {
        // Encontrar la cita por su ID
        $cita = Cita::findOrFail($id);
        $pacienteNombre = $cita->paciente->nombres . ' ' . $cita->paciente->apellidos;
        
        // Eliminar la cita de la base de datos
        $cita->delete();
        
        // Redirigir a la tabla de citas con un mensaje de éxito
        return redirect()->route('citas.tablacitas')->with('success', "Cita del paciente $pacienteNombre eliminada exitosamente.");
    }
}
