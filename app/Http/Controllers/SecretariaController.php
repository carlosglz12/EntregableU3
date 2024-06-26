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
    public function index(): View
    {
        $secretarias = Secretaria::all();
        return view('secretarias.secretarias', ['secretarias' => $secretarias]);
    }

    public function edit(Secretaria $secretaria): View
    {
        return view('secretarias.edit', ['secretaria' => $secretaria]);
    }

    public function create(): View
    {
        return view('secretarias.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:secretarias'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $secretaria = Secretaria::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        return redirect()->route('secretarias.index')->with('success', 'Nueva secretaria agregada.');
    }

    public function update(Request $request, Secretaria $secretaria): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:secretarias,email,' . $secretaria->id],
            'phone' => ['required', 'string', 'max:20'],
        ]);

        $secretaria->update([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('secretarias.index')->with('success', 'Datos de la secretaria actualizados.');
    }

    public function destroy($id): RedirectResponse
    {
        $secretaria = Secretaria::find($id);
        if ($secretaria) {
            $secretaria->delete();
            return redirect()->route('secretarias.index')->with('success', 'Secretaria eliminada exitosamente.');
        }
        return redirect()->route('secretarias.index')->with('error', 'Secretaria no encontrada.');
    }
}
