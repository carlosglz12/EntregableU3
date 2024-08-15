@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/formularios.css') }}">

@section('content')
<div class="custom-form">
    <h3>Registrar Nueva Venta</h3>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('ventas.store') }}">
        @csrf

        <!-- Selección de Paciente -->
        <div class="form-item mb-5">
            <label for="paciente">Paciente</label>
            <select id="paciente" name="paciente_id" class="form-select" required>
                <option value="">Seleccionar paciente</option>
                @foreach($pacientes as $paciente)
                    <option value="{{ $paciente->id }}">{{ $paciente->nombres }} {{ $paciente->apellidos }}</option>
                @endforeach
            </select>
        </div>

        <!-- Selección de Consulta (opcional) -->
        <div class="form-item mb-5">
            <label for="consulta">Consulta (opcional)</label>
            <select id="consulta" name="consulta_id" class="form-select">
                <option value="">Seleccionar consulta (opcional)</option>
                <!-- Las consultas se actualizarán según el paciente seleccionado -->
            </select>
        </div>

        <!-- Tabla de Servicios -->
        <div class="form-item mb-5">
            <label for="servicios" class="form-label">Servicios</label>
            <table class="table" id="servicios-table">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select class="form-select servicio-select" name="productos[0][id]" required>
                                <option value="">Selecciona un servicio</option>
                                @foreach($servicios as $servicio)
                                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" step="1" name="productos[0][precio]" class="form-control precio-input" required readonly></td>
                        <td><input type="number" name="productos[0][cantidad]" class="form-control" required></td>
                        <td><button type="button" class="btn btn-danger remove-servicio">Eliminar</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="button" id="add-servicio">Agregar Servicio</button>
        </div>

        <div class="button-container">
            <button type="submit" class="button">Guardar Venta</button>
        </div>
    </form>
</div>

<script>
    const pacientes = @json($pacientes);

    document.getElementById('paciente').addEventListener('change', function() {
        const pacienteId = this.value;
        const consultaSelect = document.getElementById('consulta');
        consultaSelect.innerHTML = '<option value="">Seleccionar consulta (opcional)</option>';

        if (pacienteId) {
            const paciente = pacientes.find(p => p.id == pacienteId);

            if (paciente && paciente.consultas) {
                paciente.consultas.forEach(consulta => {
                    const option = document.createElement('option');
                    option.value = consulta.id;
                    option.textContent = `${consulta.motivo_consulta} - ${new Date(consulta.created_at).toLocaleDateString()}`;
                    consultaSelect.appendChild(option);
                });
            }
        }
    });

    document.getElementById('add-servicio').addEventListener('click', function() {
        const table = document.getElementById('servicios-table').getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length;
        const row = table.insertRow(rowCount);
        row.innerHTML = `
            <td>
                <select class="form-select servicio-select" name="productos[${rowCount}][id]" required>
                    <option value="">Selecciona un servicio</option>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" step="1" name="productos[${rowCount}][precio]" class="form-control precio-input" required readonly></td>
            <td><input type="number" name="productos[${rowCount}][cantidad]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger remove-servicio">Eliminar</button></td>
        `;

        row.querySelector('.servicio-select').addEventListener('change', function() {
            const servicioId = this.value;
            const precioInput = this.closest('tr').querySelector('.precio-input');

            if (servicioId) {
                fetch(`/servicio/${servicioId}/precio`)
                    .then(response => response.json())
                    .then(data => {
                        precioInput.value = data.precio;
                    });
            } else {
                precioInput.value = '';
            }
        });
    });

    document.getElementById('servicios-table').addEventListener('click', function(e) {
        if (e.target && e.target.matches('button.remove-servicio')) {
            const row = e.target.closest('tr');
            row.parentNode.removeChild(row);
        }
    });

    document.querySelectorAll('.servicio-select').forEach(select => {
        select.addEventListener('change', function() {
            const servicioId = this.value;
            const precioInput = this.closest('tr').querySelector('.precio-input');

            if (servicioId) {
                fetch(`/servicio/${servicioId}/precio`)
                    .then(response => response.json())
                    .then(data => {
                        precioInput.value = data.precio;
                    });
            } else {
                precioInput.value = '';
            }
        });
    });
</script>
@endsection
