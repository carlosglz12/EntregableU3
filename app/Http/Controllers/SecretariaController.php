<?php

namespace App\Http\Controllers;

use App\Models\Secretaria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class SecretariaController extends Controller
{
    // Método para mostrar todas las secretarias
    public function index(): View
    {
        // Obtener todas las secretarias de la base de datos
        $secretarias = Secretaria::all();
        // Retornar la vista 'secretarias.secretarias' con la lista de secretarias
        return view('secretarias.secretarias', ['secretarias' => $secretarias]);
    }

    // Método para mostrar el formulario de edición de una secretaria
    public function edit(Secretaria $secretaria): View
    {
        // Retornar la vista 'secretarias.edit' con la información de la secretaria
        return view('secretarias.edit', ['secretaria' => $secretaria]);
    }

    // Método para mostrar el formulario de creación de una nueva secretaria
    public function create(): View
    {
        // Retornar la vista 'secretarias.create'
        return view('secretarias.create');
    }

    // Método para guardar una nueva secretaria en la base de datos
    public function store(Request $request): RedirectResponse
    {
        // Validar los datos del formulario
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:secretarias'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['required', 'int'],
        ]);

        // Crear y guardar la nueva secretaria en la base de datos
        $secretaria = Secretaria::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
        ]);

        // Redirigir a la lista de secretarias con un mensaje de éxito
        return redirect()->route('secretarias.index')->with('success', 'Nueva secretaria agregada.');
    }

    // Método para actualizar la información de una secretaria existente
    public function update(Request $request, Secretaria $secretaria): RedirectResponse
    {
        // Validar los datos del formulario
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:secretarias,correo,' . $secretaria->id],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['required', 'int'],
        ]);

        // Actualizar la información de la secretaria en la base de datos
        $secretaria->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
        ]);

        // Redirigir a la lista de secretarias con un mensaje de éxito
        return redirect()->route('secretarias.index')->with('success', 'Datos de la secretaria actualizados.');
    }

    // Método para eliminar una secretaria de la base de datos
    public function destroy($id): RedirectResponse
    {
        // Encontrar la secretaria por su ID
        $secretaria = Secretaria::find($id);
        if ($secretaria) {
            // Eliminar la secretaria de la base de datos
            $secretaria->delete();
            // Redirigir a la lista de secretarias con un mensaje de éxito
            return redirect()->route('secretarias.index')->with('success', 'Secretaria eliminada exitosamente.');
        }
        // Redirigir a la lista de secretarias con un mensaje de error si la secretaria no se encuentra
        return redirect()->route('secretarias.index')->with('error', 'Secretaria no encontrada.');
    }
}
