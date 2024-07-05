@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
@section('content')
<form class="custom-form" method="POST" action="{{ route('pacientes.store') }}">
    @csrf
    <h3>Agregar Paciente</h3>
    <!--Nombres y Apellidos-->
    <div class="form-group">
        <div class="form-item mb-5">
            <label for="nombres">Nombres</label>
            <input type="text" id="nombres" name="nombres" placeholder="" required />
        </div>
        <div class="form-item mb-5">
            <label for="apellidos">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" placeholder="" required />
        </div>
    </div>

    <!--Correo y Teléfono-->
    <div class="form-group">
        <div class="form-item mb-5">
            <label for="correo">Correo</label>
            <input type="email" id="correo" name="correo" placeholder="" required />
        </div>
        <div class="form-item mb-5">
            <label for="telefono">Teléfono</label>
            <input type="number" id="telefono" name="telefono" placeholder="" required />
        </div>
    </div>

    <!--Teléfono de Emergencia y Fecha de Nacimiento-->
    <div class="form-group">
        <div class="form-item mb-5">
            <label for="telefono_emergencia">Teléfono Emergencia</label>
            <input type="number" id="telefono_emergencia" name="telefono_emergencia" placeholder="" required />
        </div>
        <div class="form-item mb-5">
            <label for="fecha_nacimiento">Fecha Nacimiento</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required />
        </div>
    </div>

    <!-- Campo de Género -->
    <div class="form-group">
        <div class="form-group mb-5">
            <label>Género</label>
            <div class="form-item">
                <input id="femenino" type="radio" name="genero" value="femenino" required />
                <label for="femenino">Femenino</label>
            </div>
            <div class="form-item">
                <input id="masculino" type="radio" name="genero" value="masculino" required />
                <label for="masculino">Masculino</label>
            </div>
            <div class="form-item">
                <input id="prefiero_no_decirlo" type="radio" name="genero" value="prefiero_no_decirlo" required />
                <label for="prefiero_no_decirlo">Prefiero no decirlo</label>
            </div>
            <div class="form-item">
                <input id="otro" type="radio" name="genero" value="otro" required />
                <label for="otro">Otro</label>
            </div>
        </div>
    </div>

    <div class="form-item mb-5">
        <label for="notas">Notas:</label>
        <textarea id="notas" name="notas" rows="4" cols="50"></textarea>
    </div>

    <div class="button-container">
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar</button>
    </div>
</form>
@endsection
