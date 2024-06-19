@extends('layouts.app')

@section('title', 'Gestión de Pacientes')

@section('content')
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Correo</th>
            <th>Teléfono</th>
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
