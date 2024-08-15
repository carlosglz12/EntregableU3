@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">

@section('content')

@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: '¡Éxito!',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6',
        });
    });
</script>
@endif

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
                        <button type="button" class="button delete-button btn-delete" data-id="{{ $servicio->id }}">Eliminar</button>                    </form>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const servicioId = this.getAttribute('data-id');
            const form = this.closest('form');
            const servicioNombre = this.closest('tr').querySelector('td:nth-child(1)').textContent;

            Swal.fire({
                title: '¿Estás seguro?',
                text: `¿Quieres eliminar el servicio "${servicioNombre}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection
