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
            <td>{{ $secretaria->apellidos }}</td>
            <td>{{ $secretaria->correo }}</td>
            <td>{{ $secretaria->telefono }}</td>
            <td>
                <div class="action-buttons">
                    <a href="{{ route('secretarias.edit', $secretaria->id) }}" class="button edit-button">Editar</a>
                    <form action="{{ route('secretarias.destroy', $secretaria->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="button delete-button btn-delete" data-id="{{ $secretaria->id }}">Eliminar</button>
                    </form>
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
            const secretariaId = this.getAttribute('data-id');
            const form = this.closest('form');
            const secretariaNombre = this.closest('tr').querySelector('td:nth-child(2)').textContent;
            const secretariaApellido = this.closest('tr').querySelector('td:nth-child(3)').textContent;

            Swal.fire({
                title: '¿Estás seguro?',
                text: `¿Quieres eliminar a la secretaria ${secretariaNombre} ${secretariaApellido}?`,
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
