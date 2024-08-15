<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DoctoresController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\SecretariaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\FullCalendar;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Servicios;

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

    // Rutas para Doctores
    Route::get('/doctores', [DoctoresController::class, 'index'])->name('doctores.index');
    Route::get('/doctores/crear', [DoctoresController::class, 'create'])->name('doctores.create');
    Route::post('/doctores', [DoctoresController::class, 'store'])->name('doctores.store');
    Route::get('/doctores/{doctor}/editar', [DoctoresController::class, 'edit'])->name('doctores.edit');
    Route::put('/doctores/{doctor}', [DoctoresController::class, 'update'])->name('doctores.update');
    Route::delete('/doctores/{doctor}', [DoctoresController::class, 'destroy'])->name('doctores.destroy');

    // Rutas para Pacientes (Accesibles solo para médicos y secretarias)
    Route::get('/pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
    Route::get('/pacientes/crear', [PacientesController::class, 'create'])->name('pacientes.create');
    Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
    Route::get('/pacientes/{paciente}/editar', [PacientesController::class, 'edit'])->name('pacientes.edit');
    Route::put('/pacientes/{paciente}', [PacientesController::class, 'update'])->name('pacientes.update');
    Route::delete('/pacientes/{paciente}', [PacientesController::class, 'destroy'])->name('pacientes.destroy');

    // Rutas para Servicios
    Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios.index');
    Route::get('/servicios/crear', [ServiciosController::class, 'create'])->name('servicios.create');
    Route::post('/servicios', [ServiciosController::class, 'store'])->name('servicios.store');
    Route::get('/servicios/{servicio}/editar', [ServiciosController::class, 'edit'])->name('servicios.edit');
    Route::put('/servicios/{servicio}', [ServiciosController::class, 'update'])->name('servicios.update');
    Route::delete('/servicios/{servicio}', [ServiciosController::class, 'destroy'])->name('servicios.destroy');

    // Rutas para Secretarias
    Route::get('/secretarias', [SecretariaController::class, 'index'])->name('secretarias.index');
    Route::get('/secretarias/crear', [SecretariaController::class, 'create'])->name('secretarias.create');
    Route::post('/secretarias', [SecretariaController::class, 'store'])->name('secretarias.store');
    Route::get('/secretarias/{secretaria}/editar', [SecretariaController::class, 'edit'])->name('secretarias.edit');
    Route::put('/secretarias/{secretaria}', [SecretariaController::class, 'update'])->name('secretarias.update');
    Route::delete('/secretarias/{secretaria}', [SecretariaController::class, 'destroy'])->name('secretarias.destroy');

    // Rutas para Citas
    Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
    Route::get('/citas/crear', [CitaController::class, 'create'])->name('citas.create');
    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/tablacitas', [CitaController::class, 'tablacitas'])->name('citas.tablacitas');
    Route::get('/citas/{cita}/editar', [CitaController::class, 'editar'])->name('citas.editar');
    Route::put('/citas/{cita}', [CitaController::class, 'update'])->name('citas.update');
    Route::delete('/citas/{id}', [CitaController::class, 'eliminar'])->name('citas.eliminar');
    Route::get('/calendario-citas', [FullCalendar::class, 'index'])->name('calendario.citas.index');

    // Rutas para Consultas
    Route::get('/consultas', [ConsultaController::class, 'index'])->name('consultas.index');
    Route::get('/consultas/crear', [ConsultaController::class, 'create'])->name('consultas.create');
    Route::post('/consultas', [ConsultaController::class, 'store'])->name('consultas.store');
    Route::get('/consultas/{consulta}/editar', [ConsultaController::class, 'edit'])->name('consultas.edit');
    Route::put('/consultas/{consulta}', [ConsultaController::class, 'update'])->name('consultas.update');
    Route::delete('/consultas/{consulta}', [ConsultaController::class, 'destroy'])->name('consultas.destroy');
    Route::get('/consultas/{consulta}', [ConsultaController::class, 'show'])->name('consultas.show');
    Route::get('/consultas/{consulta}/pdf', [ConsultaController::class, 'downloadPdf'])->name('consultas.downloadPdf');


    // Ruta para crear una consulta a partir de una cita
    Route::get('/citas/{cita}/consulta', [ConsultaController::class, 'crearConsulta'])->name('consultas.crearConsulta');
    Route::post('/citas/{cita}/consulta', [ConsultaController::class, 'storeConsulta'])->name('consultas.storeConsulta');
    
    // Ruta para crear una consulta a partir de un paciente
    Route::get('/pacientes/{paciente}/consulta', [ConsultaController::class, 'crearConsultaPaciente'])->name('consultas.crearConsultaPaciente');
    Route::post('/pacientes/{paciente}/consulta', [ConsultaController::class, 'storeConsultaPaciente'])->name('consultas.storeConsultaPaciente');

    //Rutas para los roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    //ventas
    Route::resource('ventas', VentaController::class);
    Route::get('/ventas/{venta}', [VentaController::class, 'show'])->name('ventas.show');

});

// Rutas de autenticación para doctores
Route::prefix('doctor')->name('doctor.')->group(function () {
    Route::get('login', [LoginController::class, 'showDoctorLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'doctorLogin']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

// Rutas de autenticación para secretarias
Route::prefix('secretaria')->name('secretaria.')->group(function () {
    Route::get('login', [LoginController::class, 'showSecretariaLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'secretariaLogin']);
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/servicio/{id}/precio', function($id) {
    $servicio = Servicios::find($id);
    return response()->json(['precio' => $servicio->precio]);
});

require __DIR__.'/auth.php';
