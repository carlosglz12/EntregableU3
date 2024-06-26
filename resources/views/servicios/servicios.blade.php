@extends('layouts.app')

@section('content')
<button id="myBtn" class="button">Agregar Servicio</button>
<table>
    <thead>
        <tr>
            <th>Servicio</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($servicios as $servicio)
        <tr>
            <td>{{ $servicio->nombre }}</td>
            <td>{{ $servicio->descripcion }}</td>
            <td>{{ $servicio->precio }}</td>
            <td>
                <a href="{{ route('servicios.edit', $servicio->id) }}" class="button edit-button">Editar</a>
                <form action="{{ route('servicios.destroy', $servicio->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button delete-button">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Ventana Modal -->
<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Registrar Servicio</h2>
        <form method="POST" action="{{ route('servicios.store') }}">
            @csrf
            <input type="text" name="nombre" placeholder="Nombre del Servicio" required>
            <input type="text" name="descripcion" placeholder="Descripción" required>
            <input type="number" name="precio" placeholder="Precio" required>
            <button class="button" type="submit">Registrar</button>
        </form>
    </div>
</div>

<script>
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
