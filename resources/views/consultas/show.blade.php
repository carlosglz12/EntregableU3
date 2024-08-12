@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalles de la Consulta</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Paciente: {{ $consulta->paciente->nombres }} {{ $consulta->paciente->apellidos }}</h5>
            <p><strong>Fecha:</strong> {{ $consulta->created_at->format('d/m/Y') }}</p>
            <p><strong>Peso:</strong> {{ $consulta->peso }} kg</p>
            <p><strong>Talla:</strong> {{ $consulta->talla }} cm</p>
            <p><strong>Temperatura:</strong> {{ $consulta->temperatura }} °C</p>
            <p><strong>Saturación:</strong> {{ $consulta->saturacion }} %</p>
            <p><strong>Frecuencia Cardíaca:</strong> {{ $consulta->frecuencia_cardiaca }} bpm</p>
            <p><strong>Altura:</strong> {{ $consulta->altura }} cm</p>
            <p><strong>Motivo de la Consulta:</strong> {{ $consulta->motivo_consulta }}</p>
            <p><strong>Padecimiento:</strong> {{ $consulta->padecimiento }}</p>
            <p><strong>Medicamentos:</strong></p>
            <ul>
                @foreach (json_decode($consulta->medicamentos, true) as $medicamento)
                    <li>{{ $medicamento['nombre'] }} - {{ $medicamento['cantidad'] }} ({{ $medicamento['frecuencia'] }}), {{ $medicamento['duracion'] }}</li>
                @endforeach
            </ul>
            <p><strong>Notas:</strong> {{ $consulta->notas }}</p>
            <a href="{{ route('consultas.downloadPdf', $consulta->id) }}" class="btn btn-primary">Guardar en PDF</a>
        </div>
    </div>
</div>
@endsection
