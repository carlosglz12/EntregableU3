@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
@section('content')
<form class="custom-form" method="POST" action="{{ route('doctores.update', $doctor->id) }}">
    @csrf
    @method('PUT')
    <h3>Editar Doctor</h3>
    <!--Nombres y Apellidos-->
    <div class="form-group">
        <div class="form-item mb-5">
            <label for="nombres">Nombres</label>
            <input type="text" id="nombres" name="nombres" value="{{ $doctor->nombres }}" placeholder="" required />
        </div>
        <div class="form-item mb-5">
            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" value="{{ $doctor->apellidos }}" placeholder="" required />
        </div>
    </div>

    <!--Correo y Teléfono-->
    <div class="form-group">
        <div class="form-item mb-5">
            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" value="{{ $doctor->correo }}" placeholder="" required />
        </div>
        <div class="form-item mb-5">
            <label for="telefono">Teléfono</label>
            <input type="number" id="telefono" name="telefono" value="{{ $doctor->telefono }}" placeholder="" required />
        </div>
    </div>

    <!--Contraseña y Confirmar Contraseña-->
    <div class="form-group">
        <div class="form-item mb-5">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" />
        </div>
        <div class="form-item mb-5">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation" />
        </div>
    </div>

    <!--Especialidad y Consultorio-->
    <div class="form-group">
        <div class="form-item mb-5">
            <label for="especialidad">Especialidad</label>
            <input type="text" id="especialidad" name="especialidad" value="{{ $doctor->especialidad }}" placeholder="" required />
        </div>
        <div class="form-item mb-5">
            <label for="consultorio">Consultorio</label>
            <input type="number" id="consultorio" name="consultorio" value="{{ $doctor->consultorio }}" placeholder="" required />
        </div>
    </div>   

    <button type="submit" class="text-black bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Actualizar</button>
</form>
@endsection
