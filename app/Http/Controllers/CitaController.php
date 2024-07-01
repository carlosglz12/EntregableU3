<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Pacientes;
use App\Models\Doctores;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CitaController extends Controller
{
    public function index(): View
    {
        $citas = Cita::with('paciente', 'doctor')->get();
        return view('citas.citas', compact('citas'));
    }

    public function create(): View
    {
        $pacientes = Pacientes::all();
        $doctores = Doctores::all();
        return view('citas.create', compact('pacientes', 'doctores'));
    }

    public function tablacitas(): View
    {
        $citas = Cita::with('paciente', 'doctor')->get();
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

        $existingCita = Cita::where('fecha', $request->fecha)->where('hora', $request->hora)->first();

        if ($existingCita) {
            return redirect()->back()->withErrors(['fecha_hora' => 'Ya existe una cita programada para esta fecha y hora.']);
        }

        Cita::create([
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => 'en proceso'
        ]);

        return redirect()->route('citas.index')->with('success', 'Cita agendada exitosamente.');
    }

    public function editar($id): View
    {
        $cita = Cita::findOrFail($id);
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

        $cita = Cita::findOrFail($id);
        $existingCita = Cita::where('fecha', $request->fecha)->where('hora', $request->hora)->where('id', '!=', $id)->first();

        if ($existingCita) {
            return redirect()->back()->withErrors(['fecha_hora' => 'Ya existe una cita programada para esta fecha y hora.']);
        }

        $cita->update([
            'paciente_id' => $request->paciente_id,
            'doctor_id' => $request->doctor_id,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
            'estado' => $request->estado
        ]);

        return redirect()->route('citas.tablacitas')->with('success', 'Cita actualizada exitosamente.');
    }

    public function eliminar($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();
        return redirect()->route('citas.tablacitas')->with('success', 'Cita eliminada exitosamente.');
    }
}
