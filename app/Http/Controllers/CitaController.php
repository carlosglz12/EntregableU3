<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Pacientes;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    public function index()
    {
        $citas = Cita::with('paciente')->get();
        return view('citas.citas', compact('citas'));
    }

    public function create($pacienteId)
    {
        $paciente = Pacientes::findOrFail($pacienteId);
        return view('citas.create', compact('paciente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'fecha_hora' => 'required|date|after:now',
        ]);

        $existingCita = Cita::where('fecha_hora', $request->fecha_hora)->first();

        if ($existingCita) {
            return redirect()->back()->withErrors(['fecha_hora' => 'Ya existe una cita programada para esta fecha y hora.']);
        }

        Cita::create([
            'paciente_id' => $request->paciente_id,
            'fecha_hora' => $request->fecha_hora,
        ]);

        return redirect()->route('citas.index')->with('success', 'Cita agendada exitosamente.');
    }
}
