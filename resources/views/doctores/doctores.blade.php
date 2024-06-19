@extends('layouts.app')

@section('title', 'Gestión de Médicos')

@section('content')
<button id="myBtn" class="button">Agregar Médico</button>
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

<!-- Ventana Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Registrar Doctor</h2>
        <form method="POST" action="{{ route('doctores.store') }}">
            @csrf
            <input type="text" name="nombres" placeholder="Nombres" required>
            <input type="text" name="apellidos" placeholder="Apellidos" required>
            <input type="email" name="correo" placeholder="Correo" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <input type="text" name="especialidad" placeholder="Especialidad" required>
            <input type="text" name="consultorio" placeholder="Consultorio" required>
            <button class="button" type="submit">Registrar</button>
        </form>
    </div>
</div>

<script>
    // Abrir y cerrar la ventana modal
    var modal = document.getElementById("myModal");
    var btn = document.getElementById("myBtn");
    var span = document.getElementsByClassName("close")[0];

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection
