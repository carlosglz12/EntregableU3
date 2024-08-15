@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/tablas.css') }}">

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">Lista de Citas</h2>
    <table class="min-w-full bg-white">
        <thead>
            <tr>
                <th class="py-2">ID</th>
                <th class="py-2">Paciente</th>
                <th class="py-2">Doctor</th>
                <th class="py-2">Fecha</th>
                <th class="py-2">Hora</th>
                <th class="py-2">Estado</th>
                <th class="py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citas as $cita)
            <tr>
                <td class="border px-4 py-2">{{ $cita->id }}</td>
                <td class="border px-4 py-2">{{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}</td>
                <td class="border px-4 py-2">{{ $cita->doctor->nombres }} {{ $cita->doctor->apellidos }}</td>
                <td class="border px-4 py-2">{{ $cita->fecha }}</td>
                <td class="border px-4 py-2">{{ $cita->hora }}</td>
                <td class="border px-4 py-2">
                    <span class="status-label {{ $cita->estado == 'completada' ? 'status-active' : ($cita->estado == 'terminada' ? 'status-in-process' : ($cita->estado == 'cancelada' ? 'status-cancelled' : 'status-in-process')) }}">
                        {{ ucfirst($cita->estado) }}
                    </span>
                </td>
                <td class="border px-4 py-2">
                <div class="action-buttons">
                        <a href="{{ route('citas.editar', $cita->id) }}" class="button edit-button">Editar</a>
                        <button class="button delete-button" onclick="confirmDelete('{{ $cita->paciente->nombres }}', {{ $cita->id }});">Eliminar</button>
                        <a href="{{ route('consultas.crearConsulta', $cita->id) }}" class="button edit-button">Consultar</a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection


@push('scripts')
<script>
    function confirmDelete(pacienteNombre, citaId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: `No podrás revertir esto. La cita del paciente ${pacienteNombre} se eliminará.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarla!',
            cancelButtonText: 'No, cancelar!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/citas/${citaId}`;
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const csrfField = document.createElement('input');
                csrfField.type = 'hidden';
                csrfField.name = '_token';
                csrfField.value = csrfToken;
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfField);
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }
</script>
@endpush