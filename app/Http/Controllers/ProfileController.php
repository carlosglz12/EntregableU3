<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    // Método para mostrar el formulario de edición del perfil
    public function edit(Request $request): View
    {
        // Retornar la vista 'profile.edit' con la información del usuario autenticado
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    // Método para actualizar el perfil del usuario
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Llenar el modelo de usuario con los datos validados del formulario
        $request->user()->fill($request->validated());

        // Si el campo 'email' ha sido modificado, marcar el email como no verificado
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Guardar los cambios del usuario en la base de datos
        $request->user()->save();

        // Redirigir al formulario de edición del perfil con un mensaje de éxito
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    // Método para eliminar la cuenta del usuario
    public function destroy(Request $request): RedirectResponse
    {
        // Validar la contraseña del usuario para confirmar la eliminación de la cuenta
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Obtener el usuario autenticado
        $user = $request->user();

        // Cerrar la sesión del usuario
        Auth::logout();

        // Eliminar el usuario de la base de datos
        $user->delete();

        // Invalidar la sesión actual
        $request->session()->invalidate();
        // Regenerar el token de la sesión
        $request->session()->regenerateToken();

        // Redirigir a la página de inicio
        return Redirect::to('/');
    }
}
