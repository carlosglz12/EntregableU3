<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Pacientes;
use App\Models\Cita;
use App\Models\Servicios;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ConsultaController extends Controller
{
    // método para mostrar todas las consultas
    public function index(): View
    {
        // obtener todas las consultas con información del paciente, de la cita y de los servicios
        $consultas = Consulta::with('paciente', 'cita', 'servicios')->get();
        // retornar la vista 'consultas.consultas' con la lista de consultas
        return view('consultas.consultas', compact('consultas'));
    }

    // método para mostrar el formulario de creación de una nueva consulta
    public function create(Request $request): View
    {
        // obtener todos los pacientes, citas y servicios
        $pacientes = Pacientes::all();
        $citas = Cita::all();
        $servicios = Servicios::all();
        // obtener los ID de cita y paciente seleccionados desde la solicitud
        $selectedCita = $request->input('cita_id');
        $selectedPaciente = $request->input('paciente_id');

        // retornar la vista 'consultas.create' con los datos necesarios
        return view('consultas.create', compact('pacientes', 'citas', 'servicios', 'selectedCita', 'selectedPaciente'));
    }

    // método para guardar una nueva consulta en la base de datos
    public function store(Request $request): RedirectResponse
    {
        // validar los datos del formulario
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'cita_id' => 'nullable|exists:citas,id',
            'peso' => 'required|numeric',
            'talla' => 'required|numeric',
            'temperatura' => 'required|numeric',
            'saturacion' => 'required|numeric',
            'frecuencia_cardiaca' => 'required|integer',
            'altura' => 'required|numeric',
            'motivo_consulta' => 'required|string',
            'padecimiento' => 'required|string',
            'medicamentos' => 'required|array',
            'notas' => 'nullable|string',
            'servicios' => 'nullable|array',
            'servicios.*.id' => 'nullable|exists:servicios,id',
            'servicios.*.notas' => 'nullable|string',
        ]);

        // crear y guardar la nueva consulta en la base de datos
        $consulta = Consulta::create($request->all());

        // guardar los servicios asociados a la consulta
        if ($request->has('servicios')) {
            foreach ($request->servicios as $servicio) {
                $consulta->servicios()->attach($servicio['id'], ['notas' => $servicio['notas'] ?? null]);
            }
        }

        // redirigir a la lista de consultas con un mensaje de éxito
        return redirect()->route('consultas.index')->with('success', 'Consulta creada exitosamente.');
    }

    // método para mostrar el formulario de edición de una consulta existente
    public function edit(Consulta $consulta): View
    {
        // obtener todos los pacientes, citas y servicios
        $pacientes = Pacientes::all();
        $citas = Cita::all();
        $servicios = Servicios::all();

        // retornar la vista 'consultas.editar' con la consulta y los datos necesarios
        return view('consultas.editar', compact('consulta', 'pacientes', 'citas', 'servicios'));
    }

    // método para actualizar una consulta existente en la base de datos
    public function update(Request $request, Consulta $consulta): RedirectResponse
    {
        // validar los datos del formulario
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'cita_id' => 'nullable|exists:citas,id',
            'peso' => 'required|numeric',
            'talla' => 'required|numeric',
            'temperatura' => 'required|numeric',
            'saturacion' => 'required|numeric',
            'frecuencia_cardiaca' => 'required|integer',
            'altura' => 'required|numeric',
            'motivo_consulta' => 'required|string',
            'padecimiento' => 'required|string',
            'medicamentos' => 'required|array',
            'notas' => 'nullable|string',
            'servicios' => 'nullable|array',
            'servicios.*.id' => 'nullable|exists:servicios,id',
            'servicios.*.notas' => 'nullable|string',
        ]);

        // actualizar la consulta con los nuevos datos
        $consulta->update($this->extractRequestData($request));

        // actualizar los servicios asociados a la consulta
        $consulta->servicios()->detach();
        if ($request->has('servicios')) {
            foreach ($request->servicios as $servicio) {
                $consulta->servicios()->attach($servicio['id'], ['notas' => $servicio['notas'] ?? null]);
            }
        }

        // redirigir a la lista de consultas con un mensaje de éxito
        return redirect()->route('consultas.index')->with('success', 'Consulta actualizada exitosamente.');
    }

    // método para eliminar una consulta de la base de datos
    public function destroy(Consulta $consulta): RedirectResponse
    {
        // eliminar la consulta de la base de datos
        $consulta->delete();

        // redirigir a la lista de consultas con un mensaje de éxito
        return redirect()->route('consultas.index')->with('success', 'Consulta eliminada exitosamente.');
    }

    // método para crear una consulta a partir de una cita existente
    public function crearConsulta(Cita $cita): View
    {
        // obtener el paciente relacionado con la cita y todos los servicios
        $paciente = $cita->paciente;
        $servicios = Servicios::all();
        // retornar la vista 'consultas.create' con la cita, el paciente y los servicios
        return view('consultas.create', compact('cita', 'paciente', 'servicios'));
    }

    // método para guardar una consulta a partir de una cita existente en la base de datos
    public function storeConsulta(Request $request, Cita $cita)
    {
        // validar los datos del formulario
        $this->validateRequest($request);

        // crear una nueva consulta con los datos validados
        $consulta = new Consulta($this->extractRequestData($request));
        $consulta->paciente_id = $cita->paciente_id;
        $consulta->cita_id = $cita->id;

        // guardar la nueva consulta en la base de datos
        $consulta->save();

        // guardar los servicios asociados a la consulta
        if ($request->has('servicios')) {
            foreach ($request->servicios as $servicio) {
                $consulta->servicios()->attach($servicio['id'], ['notas' => $servicio['notas'] ?? null]);
            }
        }

        // redirigir a la lista de consultas con un mensaje de éxito
        return redirect()->route('consultas.index')->with('success', 'Consulta creada exitosamente.');
    }

    // método para crear una consulta a partir de un paciente registrado
    public function crearConsultaPaciente(Pacientes $paciente): View
    {
        // la cita es null porque la consulta es directa del paciente
        $cita = null;
        $servicios = Servicios::all();
        // retornar la vista 'consultas.create' con el paciente y los servicios
        return view('consultas.create', compact('cita', 'paciente', 'servicios'));
    }

    // método para guardar una consulta a partir de un paciente registrado en la base de datos
    public function storeConsultaPaciente(Request $request, Pacientes $paciente)
    {
        // validar los datos del formulario
        $this->validateRequest($request);

        // crear una nueva consulta con los datos validados
        $consulta = new Consulta($this->extractRequestData($request));
        $consulta->paciente_id = $paciente->id;

        // guardar la nueva consulta en la base de datos
        $consulta->save();

        // guardar los servicios asociados a la consulta
        if ($request->has('servicios')) {
            foreach ($request->servicios as $servicio) {
                $consulta->servicios()->attach($servicio['id'], ['notas' => $servicio['notas'] ?? null]);
            }
        }

        // redirigir a la lista de consultas con un mensaje de éxito
        return redirect()->route('consultas.index')->with('success', 'Consulta creada exitosamente.');
    }

    // método privado para validar los datos del formulario
    private function validateRequest(Request $request)
    {
        // reglas de validación para los campos del formulario
        $request->validate([
            'peso' => 'required|numeric',
            'talla' => 'required|numeric',
            'temperatura' => 'required|numeric',
            'saturacion' => 'required|numeric',
            'frecuencia_cardiaca' => 'required|integer',
            'altura' => 'required|numeric',
            'motivo_consulta' => 'required|string',
            'padecimiento' => 'required|string',
            'medicamentos' => 'required|array',
            'medicamentos.*.nombre' => 'required|string',
            'medicamentos.*.cantidad' => 'required|integer',
            'medicamentos.*.frecuencia' => 'required|string',
            'medicamentos.*.duracion' => 'required|string',
            'medicamentos.*.notas' => 'nullable|string',
            'notas' => 'nullable|string',
            'servicios' => 'nullable|array',
            'servicios.*.id' => 'nullable|exists:servicios,id',
            'servicios.*.notas' => 'nullable|string',
        ]);
    }

    // método privado para extraer los datos del formulario
    private function extractRequestData(Request $request)
    {
        // devolver un array con los datos del formulario
        return [
            'peso' => $request->peso,
            'talla' => $request->talla,
            'temperatura' => $request->temperatura,
            'saturacion' => $request->saturacion,
            'frecuencia_cardiaca' => $request->frecuencia_cardiaca,
            'altura' => $request->altura,
            'motivo_consulta' => $request->motivo_consulta,
            'padecimiento' => $request->padecimiento,
            'medicamentos' => json_encode($request->medicamentos),
            'notas' => $request->notas,
        ];
    }
}
