@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">

@section('content')
<a href="{{ route('secretarias.create') }}" class="button edit-button">Agregar Secretaria</a>
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
        @foreach ($secretarias as $secretaria)
        <tr>
            <td>{{ $secretaria->id }}</td>
            <td>{{ $secretaria->nombres }}</td>
            <td>{{ $secretaria->lapellidos }}</td>
            <td>{{ $secretaria->correo }}</td>
            <td>{{ $secretaria->telefono }}</td>
            <td>
                <div class="action-buttons">
                    <a href="{{ route('secretarias.edit', $secretaria->id) }}" class="button edit-button">Editar</a>
                    <form action="{{ route('secretarias.destroy', $secretaria->id) }}" method="POST" style="display:inline">
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
