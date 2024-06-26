@extends('layouts.app')

@section('title', 'Gestión de Secretarias')

@section('content')
<button id="myBtn" class="button">Agregar Secretaria</button>
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
            <td>{{ $secretaria->name }}</td>
            <td>{{ $secretaria->last_name }}</td>
            <td>{{ $secretaria->email }}</td>
            <td>{{ $secretaria->phone }}</td>
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

<!-- Ventana Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Registrar Secretaria</h2>
        <form method="POST" action="{{ route('secretarias.store') }}">
            @csrf
            <input type="text" name="name" placeholder="Nombres" required>
            <input type="text" name="last_name" placeholder="Apellidos" required>
            <input type="email" name="email" placeholder="Correo" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
            <input type="text" name="phone" placeholder="Teléfono" required>
            <button class="button" type="submit">Registrar</button>
        </form>
    </div>
</div>
@endsection
