@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/formularios.css') }}">

@section('content')
<form class="custom-form" method="POST" action="{{ route('citas.update', $cita->id) }}">
    @csrf
    @method('PUT')
    <h3>Editar Cita</h3>
    <div class="form-group">
        <div class="form-item mb-5">
            <label for="paciente_id">Paciente</label>
            <select id="paciente_id" name="paciente_id" required>
                <option value="">Seleccione un paciente</option>
                @foreach ($pacientes as $paciente)
                    <option value="{{ $paciente->id }}" {{ $paciente->id == $cita->paciente_id ? 'selected' : '' }}>
                        {{ $paciente->nombres }} {{ $paciente->apellidos }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-item mb-5">
            <label for="doctor_id">Doctor</label>
            <select id="doctor_id" name="doctor_id" required>
                <option value="">Seleccione un doctor</option>
                @foreach ($doctores as $doctor)
                    <option value="{{ $doctor->id }}" {{ $doctor->id == $cita->doctor_id ? 'selected' : '' }}>
                        {{ $doctor->nombres }} {{ $doctor->apellidos }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-item mb-5">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" value="{{ $cita->fecha }}" required />
        </div>
        <div class="form-item mb-5">
            <label for="hora">Hora</label>
            <select id="hora" name="hora" required>
                @for ($i = 0; $i < 24; $i++)
                    @for ($j = 0; $j < 60; $j += 30)
                        @php
                            $time = sprintf('%02d:%02d', $i, $j);
                        @endphp
                        <option value="{{ $time }}" {{ $time == $cita->hora ? 'selected' : '' }}>
                            {{ date('h:i A', strtotime($time)) }}
                        </option>
                    @endfor
                @endfor
            </select>
        </div>
        <div class="form-item mb-5">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" required>
                <option value="completada" {{ $cita->estado == 'completada' ? 'selected' : '' }}>Completada</option>
                <option value="terminada" {{ $cita->estado == 'terminada' ? 'selected' : '' }}>Terminada</option>
                <option value="en proceso" {{ $cita->estado == 'en proceso' ? 'selected' : '' }}>En proceso</option>
                <option value="cancelada" {{ $cita->estado == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>
    </div>
    <div class="flex justify-center">
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Actualizar</button>
    </div>
</form>
@endsection
