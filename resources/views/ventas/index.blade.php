@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">
@section('content')
<a href="{{ route('ventas.create' )}}" class="button edit-button"">Crear Venta</a>

<div class="container">

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>

            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
            <tr>
                <td>{{ $venta->id }}</td>
                <td>{{ $venta->paciente->nombres }} {{ $venta->paciente->apellidos }}</td>
                <td>{{ $venta->total }}</td>
                <td>{{ $venta->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('ventas.show', $venta->id) }}" class="button">Ver</a>
                </td> 
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
