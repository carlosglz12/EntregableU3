@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">

@section('content')
<a href="{{ route('servicios.create') }}" class="button edit-button">Agregar servicio</a>
<table>
    <thead>
        <tr>
            <th>Servicio</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($servicios as $servicio)
        <tr>
            <td>{{ $servicio->nombre }}</td>
            <td>{{ $servicio->descripcion }}</td>
            <td>{{ $servicio->precio }}</td>
            <td>
                <div class="action-buttons">
                    <a href="{{ route('servicios.edit', $servicio->id) }}" class="button edit-button">Editar</a>
                    <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button delete-button">Eliminar</button>
                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
