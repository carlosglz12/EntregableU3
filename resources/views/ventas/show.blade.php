@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">
@section('content')

<div class="container custom-form">
    <h3>Detalles de la Venta</h3>

    <div class="form-group">
        <label for="venta_id" class="form-label">ID de Venta:</label>
        <p id="venta_id">{{ $venta->id }}</p>
    </div>

    <div class="form-group">
        <label for="paciente" class="form-label">Paciente:</label>
        <p id="paciente">{{ $venta->paciente->nombres }} {{ $venta->paciente->apellidos }}</p>
    </div>

    <div class="form-group">
        <label for="consulta" class="form-label">Consulta:</label>
        <p id="consulta">{{ $venta->consulta ? $venta->consulta->motivo_consulta : 'Sin consulta' }}</p>
    </div>

    <div class="form-group">
        <label for="total" class="form-label">Total:</label>
        <p id="total">{{ $venta->total }}</p>
    </div>

    <div class="form-group">
        <label for="fecha" class="form-label">Fecha:</label>
        <p id="fecha">{{ $venta->created_at->format('d/m/Y') }}</p>
    </div>

    <h4>Productos</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($venta->productos as $producto)
            <tr>
                <td>{{ $producto->servicio->nombre }}</td>
                <td>{{ $producto->precio }}</td>
                <td>{{ $producto->cantidad }}</td>
                <td>{{ $producto->precio * $producto->cantidad }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('ventas.index') }}" class="button">Volver a la lista de ventas</a>
</div>

@endsection
