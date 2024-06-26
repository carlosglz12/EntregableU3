<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctoresController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\UserManagementController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/create', [UserManagementController::class, 'create'])->name('admin.users.create');
        Route::get('/admin/users/{user}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [UserManagementController::class, 'update'])->name('admin.users.update');
    });

    Route::middleware(['role:medico'])->group(function () {
        Route::get('/doctores', [DoctoresController::class, 'index'])->name('doctores.index');
        Route::get('/doctores/crear', [DoctoresController::class, 'create'])->name('doctores.create');
        Route::post('/doctores', [DoctoresController::class, 'store'])->name('doctores.store');
        Route::get('/doctores/{doctor}/editar', [DoctoresController::class, 'edit'])->name('doctores.edit');
        Route::put('/doctores/{doctor}', [DoctoresController::class, 'update'])->name('doctores.update');
        Route::delete('/doctores/{doctor}', [DoctoresController::class, 'destroy'])->name('doctores.destroy');

        Route::get('/pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
        Route::get('/pacientes/crear', [PacientesController::class, 'create'])->name('pacientes.create');
        Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
        Route::get('/pacientes/{paciente}/editar', [PacientesController::class, 'edit'])->name('pacientes.edit');
        Route::put('/pacientes/{paciente}', [PacientesController::class, 'update'])->name('pacientes.update');
        Route::delete('/pacientes/{paciente}', [PacientesController::class, 'destroy'])->name('pacientes.destroy');

        Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios.index');
        Route::get('/servicios/crear', [ServiciosController::class, 'create'])->name('servicios.create');
        Route::post('/servicios', [ServiciosController::class, 'store'])->name('servicios.store');
        Route::get('/servicios/{servicio}/editar', [ServiciosController::class, 'edit'])->name('servicios.edit');
        Route::put('/servicios/{servicio}', [ServiciosController::class, 'update'])->name('servicios.update');
        Route::delete('/servicios/{servicio}', [ServiciosController::class, 'destroy'])->name('servicios.destroy');

        Route::get('/secretarias', [SecretariaController::class, 'index'])->name('secretarias.index');
        Route::get('/secretarias/crear', [SecretariaController::class, 'create'])->name('secretarias.create');
        Route::post('/secretarias', [SecretariaController::class, 'store'])->name('secretarias.store');
        Route::get('/secretarias/{secretaria}/editar', [SecretariaController::class, 'edit'])->name('secretarias.edit');
        Route::put('/secretarias/{secretaria}', [SecretariaController::class, 'update'])->name('secretarias.update');
        Route::delete('/secretarias/{secretaria}', [SecretariaController::class, 'destroy'])->name('secretarias.destroy');

        Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
        Route::get('/citas/crear/{paciente}', [CitaController::class, 'create'])->name('citas.create');
        Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
    });

    Route::middleware(['role:secretaria'])->group(function () {
        Route::get('/doctores', [DoctoresController::class, 'index'])->name('doctores.index');
        Route::get('/pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
        Route::get('/pacientes/crear', [PacientesController::class, 'create'])->name('pacientes.create');
        Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
        Route::get('/pacientes/{paciente}/editar', [PacientesController::class, 'edit'])->name('pacientes.edit');
        Route::put('/pacientes/{paciente}', [PacientesController::class, 'update'])->name('pacientes.update');
        Route::delete('/pacientes/{paciente}', [PacientesController::class, 'destroy'])->name('pacientes.destroy');

        Route::get('/secretarias', [SecretariaController::class, 'index'])->name('secretarias.index');
        Route::get('/secretarias/crear', [SecretariaController::class, 'create'])->name('secretarias.create');
        Route::post('/secretarias', [SecretariaController::class, 'store'])->name('secretarias.store');
        Route::get('/secretarias/{secretaria}/editar', [SecretariaController::class, 'edit'])->name('secretarias.edit');
        Route::put('/secretarias/{secretaria}', [SecretariaController::class, 'update'])->name('secretarias.update');
        Route::delete('/secretarias/{secretaria}', [SecretariaController::class, 'destroy'])->name('secretarias.destroy');

        Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
        Route::get('/citas/crear/{paciente}', [CitaController::class, 'create'])->name('citas.create');
        Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
    });
});

require __DIR__.'/auth.php';
