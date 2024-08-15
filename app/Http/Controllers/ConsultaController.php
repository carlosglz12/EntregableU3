<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Pacientes;
use App\Models\Cita;
use App\Models\Servicios;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\Venta;

class ConsultaController extends Controller
{
    // Método para mostrar todas las consultas
    public function index(): View
    {
        // Obtener todas las consultas con información del paciente, de la cita y de los servicios
        $consultas = Consulta::with('paciente', 'cita', 'servicios')->get();
        // Retornar la vista 'consultas.consultas' con la lista de consultas
        return view('consultas.consultas', compact('consultas'));
    }

    public function create(Request $request): View|RedirectResponse
    {
        // Obtener el ID del paciente desde la solicitud
        $pacienteId = $request->input('paciente_id');
        $paciente = Pacientes::find($pacienteId);

        // Verificar si el paciente existe
        if (!$paciente) {
            // Redirigir de vuelta con un mensaje de error si el paciente no existe
            return redirect()->route('pacientes.index')->with('error', 'El paciente seleccionado no existe.');
        }

        // Obtener la cita seleccionada (si existe)
        $citaId = $request->input('cita_id');
        $cita = Cita::find($citaId);

        // Obtener todos los servicios disponibles
        $servicios = Servicios::all();

        // Retornar la vista 'consultas.create' con los datos necesarios
        return view('consultas.create', compact('paciente', 'cita', 'servicios'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'paciente_id' => 'required|exists:pacientes,id',
                'cita_id' => 'nullable|exists:citas,id',
                'peso' => 'required|numeric|min:0|max:99.99',
                'talla' => 'required|numeric|min:0|max:99.99',
                'temperatura' => 'required|numeric|min:0|max:99.99',
                'saturacion' => 'required|numeric|min:0|max:99.99',
                'frecuencia_cardiaca' => 'required|integer|min:0|max:99',
                'altura' => 'required|numeric|min:0|max:99.99',
                'motivo_consulta' => 'required|string',
                'padecimiento' => 'required|string',
                'medicamentos' => 'required|array',
                'notas' => 'nullable|string',
                'servicios' => 'nullable|array',
                'servicios.*.id' => 'nullable|exists:servicios,id',
                'servicios.*.cantidad' => 'required|integer|min:1',
                'servicios.*.notas' => 'nullable|string',
            ]);
    
            // Crear la consulta
            $consulta = Consulta::create($this->extractRequestData($request));
    
            // Asociar servicios a la consulta
            if ($request->has('servicios')) {
                foreach ($request->servicios as $servicio) {
                    $consulta->servicios()->attach($servicio['id'], ['notas' => $servicio['notas'] ?? null]);
                }
            }
    
            // Crear la venta asociada a la consulta
            $venta = Venta::create([
                'paciente_id' => $consulta->paciente_id,
                'subtotal' => 0,
                'total' => 0,
            ]);
    
            $subtotal = 0;
    
            foreach ($consulta->servicios as $servicio) {
                $precio = $servicio->precio;
                $cantidad = 1; // Asume cantidad 1 por servicio, ajustar si es necesario
                $subtotal += $precio * $cantidad;
    
                $venta->productos()->create([
                    'servicio_id' => $servicio->id,
                    'cantidad' => $cantidad,
                    'precio' => $precio,
                ]);
            }
    
            // Actualizar subtotal y total en la venta
            $venta->update([
                'subtotal' => $subtotal,
                'total' => $subtotal,
            ]);
    
            // Verificar los datos de la venta antes de redirigir
            dd('Venta creada: ', $venta, 'Productos: ', $venta->productos);
    
            return redirect()->route('consultas.index')->with('success', 'Consulta y venta creadas exitosamente.');
        } catch (\Exception $e) {
            // Si ocurre un error, redirigir de vuelta con un mensaje de error
            return redirect()->back()->with('error', 'Error al guardar la consulta: ' . $e->getMessage())->withInput();
        }
    }
    
    
    // Método para mostrar los detalles de una consulta específica
    public function show(Consulta $consulta): View
    {
        // Retornar la vista 'consultas.show' con los detalles de la consulta
        return view('consultas.show', compact('consulta'));
    }

    // Método para mostrar el formulario de edición de una consulta existente
    public function edit(Consulta $consulta): View
    {
        // Obtener todos los pacientes, citas y servicios
        $pacientes = Pacientes::all();
        $citas = Cita::all();
        $servicios = Servicios::all();

        // Retornar la vista 'consultas.editar' con la consulta y los datos necesarios
        return view('consultas.editar', compact('consulta', 'pacientes', 'citas', 'servicios'));
    }

    public function update(Request $request, Consulta $consulta): RedirectResponse
    {
        $request->validate([
            'paciente_id' => 'required|exists:pacientes,id',
            'cita_id' => 'nullable|exists:citas,id',
            'peso' => 'required|numeric|max:99',
            'talla' => 'required|numeric|max:99',
            'temperatura' => 'required|numeric|max:99',
            'saturacion' => 'required|numeric|max:99',
            'frecuencia_cardiaca' => 'required|integer|max:99',
            'altura' => 'required|numeric|max:99',
            'motivo_consulta' => 'required|string',
            'padecimiento' => 'required|string',
            'medicamentos' => 'required|array',
            'notas' => 'nullable|string',
            'servicios' => 'nullable|array',
            'servicios.*.id' => 'nullable|exists:servicios,id',
            'servicios.*.notas' => 'nullable|string',
        ]);

        $consulta->update($this->extractRequestData($request));

        $consulta->servicios()->detach();
        if ($request->has('servicios')) {
            foreach ($request->servicios as $servicio) {
                $consulta->servicios()->attach($servicio['id'], [
                    'notas' => $servicio['notas'] ?? null,
                    'cantidad' => $servicio['cantidad'],
                ]);
            }
        }

        return redirect()->route('consultas.index')->with('success', 'Consulta actualizada exitosamente.');
    }

    public function crearConsulta(Cita $cita): View
    {
        $paciente = $cita->paciente;
        $servicios = Servicios::all();
        return view('consultas.create', compact('cita', 'paciente', 'servicios'));
    }

    public function storeConsulta(Request $request, Cita $cita)
    {
        // Validar los datos del formulario
        $this->validateRequest($request);
        $consulta = new Consulta($this->extractRequestData($request));
        $consulta->paciente_id = $cita->paciente_id;
        $consulta->cita_id = $cita->id;
        $consulta->save();
        if ($request->has('servicios')) {
            foreach ($request->servicios as $servicio) {
                $consulta->servicios()->attach($servicio['id'], ['notas' => $servicio['notas'] ?? null]);
            }
        }
        return redirect()->route('consultas.index')->with('success', 'Consulta creada exitosamente.');
    }


    public function crearConsultaPaciente(Pacientes $paciente): View
    {
        $cita = null;
        $servicios = Servicios::all();
        return view('consultas.create', compact('cita', 'paciente', 'servicios'));
    }

    // Método para guardar una consulta a partir de un paciente registrado en la base de datos
    public function storeConsultaPaciente(Request $request, Pacientes $paciente)
    {
        // Validar los datos del formulario
        $this->validateRequest($request);

        // Crear una nueva consulta con los datos validados
        $consulta = new Consulta($this->extractRequestData($request));
        $consulta->paciente_id = $paciente->id;

        // Guardar la nueva consulta en la base de datos
        $consulta->save();

        // Guardar los servicios asociados a la consulta


        // Redirigir a la lista de consultas con un mensaje de éxito
        return redirect()->route('consultas.index')->with('success', 'Consulta creada exitosamente.');
    }

    // Método privado para validar los datos del formulario
    private function validateRequest(Request $request)
    {
        // Reglas de validación para los campos del formulario
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


    private function extractRequestData(Request $request)
    {
        // Devolver un array con los datos del formulario
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
