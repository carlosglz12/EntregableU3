<?php
//controlador de servicios
namespace App\Http\Controllers;

use App\Models\Servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; 

class ServiciosController extends Controller
{
    // Mostrar vista register cuando se de clic en crear 
    public function index(): View
    {
        $servicios = Servicios::all();
        return view('servicios.servicios', ['servicios' => $servicios]);
    }

    // Método para mostrar el formulario de edición
    public function edit($id): View
    {
        $servicio = Servicios::findOrFail($id);
        return view('servicios.edit', compact('servicio'));
    }

    // Formulario de crear servicio
    public function create(): View
    {
        return view('servicios.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
            'precio' => ['required', 'int'],
        ]);

        $servicio = Servicios::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
        ]);

        return redirect()->route('servicios.index')->with('success', 'Nuevo servicio agregado.');
    }

    // Método para actualizar el servicio
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
            'precio' => ['required', 'int'],
        ]);

        $servicio = Servicios::findOrFail($id);
        $servicio->update($request->all());

        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado.');
    }

    // Método para eliminar el servicio
    public function destroy($id): RedirectResponse
    {
        $servicio = Servicios::find($id);
        if ($servicio) {
            $servicio->delete();
            return redirect()->route('servicios.index')->with('success', 'Servicio eliminado exitosamente.');
        }
        return redirect()->route('servicios.index')->with('error', 'Servicio no encontrado.');
    }
}

?>
