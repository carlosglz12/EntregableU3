@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">

@section('content')
<a href="{{ route('pacientes.create') }}" class="button edit-button">Agregar Paciente</a>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Teléfono_Emergencia</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pacientes as $paciente)
        <tr>
            <td>{{ $paciente->id }}</td>
            <td>{{ $paciente->nombres }}</td>
            <td>{{ $paciente->apellidos }}</td>
            <td>{{ $paciente->correo }}</td>
            <td>{{ $paciente->telefono }}</td>
            <td>{{ $paciente->telefono_emergencia }}</td>
            <td>
                <div class="action-buttons">
                    <a href="{{ route('pacientes.edit', $paciente->id) }}" class="button edit-button">Editar</a>
                    <form action="{{ route('pacientes.destroy', $paciente->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button delete-button">Eliminar</button>
                    </form>
                    <a href="{{ route('citas.create', $paciente->id) }}" class="button">Agendar Cita</a>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
