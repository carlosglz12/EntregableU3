@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Lista de Consultas</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Fecha</th>
                <th>Motivo de Consulta</th>
                <th>Padecimiento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($consultas as $consulta)
            <tr>
                <td>{{ $consulta->id }}</td>
                <td>{{ $consulta->paciente->nombres }} {{ $consulta->paciente->apellidos }}</td>
                <td>{{ $consulta->created_at->format('d/m/Y') }}</td>
                <td>{{ $consulta->motivo_consulta }}</td>
                <td>{{ $consulta->padecimiento }}</td>
                <td>
                    <a href="{{ route('consultas.show', $consulta->id) }}" class="btn btn-info">Ver</a>
                    <a href="{{ route('consultas.edit', $consulta->id) }}" class="btn btn-warning">Editar</a>
                    <form action="{{ route('consultas.destroy', $consulta->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

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

@endsection


<style>
.container {
    background-color: #fff;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    width: 90%;
    max-width: 1200px;
    margin: 2rem auto;
}

h2 {
    text-align: center;
    padding-bottom: 15px;
}

.table {
    width: 100%;
    margin: 20px 0;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: left;
}

.table th {
    background-color: #f2f2f2;
}

.btn {
    padding: 5px 10px;
    margin: 0 5px;
    border: none;
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
}

.btn-info {
    background-color: #17a2b8;
}

.btn-info:hover {
    background-color: #138496;
}

.btn-warning {
    background-color: #ffc107;
}

.btn-warning:hover {
    background-color: #e0a800;
}

.btn-danger {
    background-color: #dc3545;
}

.btn-danger:hover {
    background-color: #c82333;
}
</style>
