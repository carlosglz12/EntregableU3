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
                        <button type="submit" class="button delete-button btn-delete" data-id="{{ $doctor->id }}">Eliminar</button>
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
            const doctorId = this.getAttribute('data-id');
            const form = this.closest('form');
            const doctorName = this.closest('tr').querySelector('td:nth-child(2)').textContent;

            Swal.fire({
                title: '¿Estás seguro?',
                text: `¿Quieres eliminar al doctor ${doctorName}?`,
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
