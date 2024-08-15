<?php

namespace App\Http\Controllers;

use App\Models\Secretaria;
use App\Models\User;
use App\Models\Role;

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

        // Crear y guardar el nuevo usuario en la tabla users
        User::create([
            'name' => $secretaria->nombres . ' ' . $secretaria->apellidos,
            'email' => $secretaria->correo,
            'password' => Hash::make($request->password),
            'role_id' => Role::where('name', 'Secretaria')->first()->id,
        ]);

        // Redirigir a la lista de secretarias con un mensaje de éxito
        return redirect()->route('secretarias.index')->with('success', 'Nueva secretaria agregada.');
    }

    public function update(Request $request, Secretaria $secretaria): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:secretarias,correo,' . $secretaria->id],
            'telefono' => ['required', 'string'],
        ]);
    
        $data = [
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
        ];
    
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            $data['password'] = Hash::make($request->password);
        }
    
        $secretaria->update($data);
    
        // Actualizar el usuario correspondiente
        $user = User::where('email', $secretaria->correo)->first();
        if ($user) {
            $user->update([
                'name' => $secretaria->nombres . ' ' . $secretaria->apellidos,
                'email' => $secretaria->correo,
            ]);
            if (isset($data['password'])) {
                $user->update(['password' => $data['password']]);
            }
        }
    
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
