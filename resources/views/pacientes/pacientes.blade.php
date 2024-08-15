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
                        <button type="button" class="button delete-button btn-delete" data-id="{{ $paciente->id }}">Eliminar</button>
                    </form>
                    <a href="{{ route('citas.create', $paciente->id) }}" class="button">Agendar Cita</a>
                    <a href="{{ route('consultas.crearConsultaPaciente', $paciente->id) }}" class="button edit-button">Consultar</a>
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
            const pacienteId = this.getAttribute('data-id');
            const form = this.closest('form');
            const pacienteNombre = this.closest('tr').querySelector('td:nth-child(2)').textContent;
            const pacienteApellido = this.closest('tr').querySelector('td:nth-child(3)').textContent;

            Swal.fire({
                title: '¿Estás seguro?',
                text: `¿Quieres eliminar al paciente ${pacienteNombre} ${pacienteApellido}?`,
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