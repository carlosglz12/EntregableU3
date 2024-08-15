<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Pacientes;
use App\Models\Servicios;
use App\Models\ProductoVenta;
use App\Models\Consulta;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class VentaController extends Controller
{
    // Mostrar la lista de ventas
    public function index(): View
    {
        $ventas = Venta::with('paciente', 'productos.servicio')->get();
        return view('ventas.index', compact('ventas'));
    }

    // Mostrar el formulario para crear una nueva venta
    public function create(): View
    {
        $servicios = Servicios::all();
        $consultas = Consulta::all();
        $pacientes = Pacientes::with('consultas')->get(); 
        return view('ventas.create', compact('servicios', 'pacientes', 'consultas'));
    }

    // Guardar una nueva venta en la base de datos
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'paciente_id' => 'nullable|exists:pacientes,id',
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:servicios,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        $venta = Venta::create([
            'paciente_id' => $request->paciente_id,
            'subtotal' => 0,
            'total' => 0,
        ]);

        $subtotal = 0;

        foreach ($request->productos as $producto) {
            $servicio = Servicios::find($producto['id']);
            $precio = $servicio->precio;
            $cantidad = $producto['cantidad'];
            $subtotal += $precio * $cantidad;

            $venta->productos()->create([
                'servicio_id' => $servicio->id,
                'cantidad' => $cantidad,
                'precio' => $precio,
            ]);
        }

        $venta->update([
            'subtotal' => $subtotal,
            'total' => $subtotal, // Aquí se puede agregar lógica para impuestos u otros cargos
        ]);

        return redirect()->route('ventas.index')->with('success', 'Venta creada exitosamente.');
    }

    // Mostrar los detalles de una venta específica
    public function show(Venta $venta): View
    {
        $venta->load('paciente', 'productos.servicio');
        return view('ventas.show', compact('venta'));
    }

    // Mostrar el formulario para editar una venta existente
    public function edit(Venta $venta): View
    {
        $venta->load('productos.servicio');
        $servicios = Servicio::all();
        $pacientes = Paciente::all();
        return view('ventas.edit', compact('venta', 'servicios', 'pacientes'));
    }

    // Actualizar una venta existente en la base de datos
    public function update(Request $request, Venta $venta): RedirectResponse
    {
        $request->validate([
            'paciente_id' => 'nullable|exists:pacientes,id',
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:servicios,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        $venta->update([
            'paciente_id' => $request->paciente_id,
        ]);

        $venta->productos()->delete();

        $subtotal = 0;

        foreach ($request->productos as $producto) {
            $servicio = Servicio::find($producto['id']);
            $precio = $servicio->precio;
            $cantidad = $producto['cantidad'];
            $subtotal += $precio * $cantidad;

            $venta->productos()->create([
                'servicio_id' => $servicio->id,
                'cantidad' => $cantidad,
                'precio' => $precio,
            ]);
        }

        $venta->update([
            'subtotal' => $subtotal,
            'total' => $subtotal,
        ]);

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente.');
    }

    // Eliminar una venta de la base de datos
    public function destroy(Venta $venta): RedirectResponse
    {
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente.');
    }


}
