@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">

@section('content')
<a href="{{ route('doctores.create') }}" class="button edit-button">Agregar Médico</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Especialidad</th>
            <th>Consultorio</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($doctores as $doctor)
        <tr>
            <td>{{ $doctor->id }}</td>
            <td>{{ $doctor->nombres }}</td>
            <td>{{ $doctor->apellidos }}</td>
            <td>{{ $doctor->correo }}</td>
            <td>{{ $doctor->telefono }}</td>
            <td>{{ $doctor->especialidad }}</td>
            <td>{{ $doctor->consultorio }}</td>
            <td>
                <div class="action-buttons">
                    <a href="{{ route('doctores.edit', $doctor->id) }}" class="button edit-button">Editar</a>
                    <form action="{{ route('doctores.destroy', $doctor->id) }}" method="POST" style="display:inline">
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
