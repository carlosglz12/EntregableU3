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


    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            'fecha' => 'required|date|after:yesterday',
            'hora' => 'required',
        ]);
    
        // Verificar si ya existe una cita en la misma fecha y hora con el mismo doctor que no esté cancelada o completada
        $citaExistente = Cita::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('doctor_id', $request->doctor_id)
            ->whereNotIn('estado', ['cancelada', 'completada'])
            ->first();
    
        if ($citaExistente) {
            return redirect()->back()->with('error', 'Ya existe una cita programada para esta fecha y hora con este doctor. Por favor, elige otra hora.');
        }
    
        try {
            Cita::create([
                'paciente_id' => $request->paciente_id,
                'doctor_id' => $request->doctor_id,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'estado' => 'en proceso'
            ]);
            return redirect()->route('citas.index')->with('success', 'Cita agendada exitosamente.');
        } catch (\Exception $e) {
            \Log::error('Error al agendar cita: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema al agendar la cita. Por favor, intenta nuevamente.');
        }
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'doctor_id' => 'required|exists:doctores,id',
            'fecha' => 'required|date|after:now',
            'hora' => 'required',
            'estado' => 'required|in:completada,terminada,en proceso,cancelada'
        ]);
    
        // Verificar si ya existe una cita en la misma fecha y hora con el mismo doctor que no esté cancelada o completada
        $citaExistente = Cita::where('fecha', $request->fecha)
            ->where('hora', $request->hora)
            ->where('doctor_id', $request->doctor_id)
            ->where('id', '!=', $id) // Excluir la cita actual
            ->whereNotIn('estado', ['cancelada', 'completada'])
            ->first();
    
        if ($citaExistente) {
            return redirect()->back()->with('error', 'Ya existe una cita programada para esta fecha y hora con este doctor. Por favor, elige otra hora.');
        }
    
        // Encontrar la cita por su ID
        $cita = Cita::findOrFail($id);
    
        try {
            $cita->update([
                'paciente_id' => $request->paciente_id,
                'doctor_id' => $request->doctor_id,
                'fecha' => $request->fecha,
                'hora' => $request->hora,
                'estado' => $request->estado
            ]);
            return redirect()->route('citas.tablacitas')->with('success', 'Cita actualizada exitosamente.');
        } catch (\Exception $e) {
            \Log::error('Error al actualizar la cita: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema al actualizar la cita. Por favor, intenta nuevamente.');
        }
    }
    

    // Método para eliminar una cita de la base de datos
    public function eliminar($id)
    {
        // Encontrar la cita por su ID
        $cita = Cita::findOrFail($id);
        $pacienteNombre = $cita->paciente->nombres . ' ' . $cita->paciente->apellidos;
        
        // Eliminar la cita de la base de datos
        try {
            $cita->delete();
            return redirect()->route('citas.tablacitas')->with('success', "Cita del paciente $pacienteNombre eliminada exitosamente.");
        } catch (\Exception $e) {
            // Registrar el error en el log de Laravel para depuración
            \Log::error('Error al eliminar la cita: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Hubo un problema al eliminar la cita. Por favor, intenta nuevamente.');
        }
    }
}
