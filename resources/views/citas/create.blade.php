@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/formularios.css') }}">

@section('content')
@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
        });
    </script>
@endif

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('success') }}',
        });
    </script>
@endif

<form class="custom-form" method="POST" action="{{ route('citas.store') }}">
    @csrf
    <h3>Agendar Cita</h3>
    <div class="form-group">
        <div class="form-item mb-5">
            <label for="paciente_id">Paciente</label>
            <select id="paciente_id" name="paciente_id" required>
                <option value="">Seleccione un paciente</option>
                @foreach ($pacientes as $paciente)
                    <option value="{{ $paciente->id }}">{{ $paciente->nombres }} {{ $paciente->apellidos }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-item mb-5">
            <label for="doctor_id">Doctor</label>
            <select id="doctor_id" name="doctor_id" required>
                <option value="">Seleccione un doctor</option>
                @foreach ($doctores as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->nombres }} {{ $doctor->apellidos }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="form-item mb-5">
            <label for="fecha">Fecha</label>
            <input type="date" id="fecha" name="fecha" required />
        </div>
        <div class="form-item mb-5">
            <label for="hora">Hora</label>
            <select id="hora" name="hora" required>
                <option value="">Seleccione una hora</option>
                @for ($i = 0; $i < 24*2; $i++)
                    @php
                        $time = strtotime('00:00') + $i * 30 * 60;
                        $timeDisplay = date('h:i A', $time);
                        $timeValue = date('H:i:s', $time);
                    @endphp
                    <option value="{{ $timeValue }}">{{ $timeDisplay }}</option>
                @endfor
            </select>
        </div>
    </div>
    <div class="flex justify-center">
        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Agendar</button>
    </div>
</form>
@endsection
