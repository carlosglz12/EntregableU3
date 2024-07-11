@extends('layouts.app')

@section('content')
<div class="custom-form">
    <h3>Registrar Nueva Consulta para {{ $paciente->nombres }} {{ $paciente->apellidos }}</h3>

    <form method="POST" action="{{ $cita ? route('consultas.storeConsulta', $cita->id) : route('consultas.storeConsultaPaciente', $paciente->id) }}">
        @csrf
        <div class="form-group">
            <div class="form-item">
                <label for="peso" class="form-label">Peso</label>
                <input type="number" step="0.01" class="form-control" id="peso" name="peso" required>
            </div>
            <div class="form-item">
                <label for="talla" class="form-label">Talla</label>
                <input type="number" step="0.01" class="form-control" id="talla" name="talla" required>
            </div>
        </div>
        <div class="form-group">
            <div class="form-item">
                <label for="temperatura" class="form-label">Temperatura</label>
                <input type="number" step="0.1" class="form-control" id="temperatura" name="temperatura" required>
            </div>
            <div class="form-item">
                <label for="saturacion" class="form-label">Saturación</label>
                <input type="number" step="0.1" class="form-control" id="saturacion" name="saturacion" required>
            </div>
        </div>
        <div class="form-group">
            <div class="form-item">
                <label for="frecuencia_cardiaca" class="form-label">Frecuencia Cardíaca</label>
                <input type="number" class="form-control" id="frecuencia_cardiaca" name="frecuencia_cardiaca" required>
            </div>
            <div class="form-item">
                <label for="altura" class="form-label">Altura</label>
                <input type="number" step="0.01" class="form-control" id="altura" name="altura" required>
            </div>
        </div>
        <div class="form-group">
            <div class="form-item">
                <label for="motivo_consulta" class="form-label">Motivo de la Consulta</label>
                <textarea class="form-control" id="motivo_consulta" name="motivo_consulta" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="form-item">
                <label for="padecimiento" class="form-label">Padecimiento</label>
                <textarea class="form-control" id="padecimiento" name="padecimiento" required></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="form-item">
                <label for="medicamentos" class="form-label">Medicamentos</label>
                <table class="table" id="medicamentos-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Frecuencia</th>
                            <th>Duración</th>
                            <th>Notas</th>
                            <th>Acciones
                                <button type="button" class="btn btn-secondary" id="add-medicamento">Agregar Medicamento</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" class="form-control" name="medicamentos[0][nombre]" required></td>
                            <td><input type="number" class="form-control" name="medicamentos[0][cantidad]" required></td>
                            <td><input type="text" class="form-control" name="medicamentos[0][frecuencia]" required></td>
                            <td><input type="text" class="form-control" name="medicamentos[0][duracion]" required></td>
                            <td><textarea class="form-control" name="medicamentos[0][notas]"></textarea></td>
                            <td><button type="button" class="btn btn-danger remove-medicamento">Eliminar</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-group">
            <div class="form-item">
                <label for="servicios" class="form-label">Servicios</label>
                <table class="table" id="servicios-table">
                    <thead>
                        <tr>
                            <th>Servicio</th>
                            <th>Notas</th>
                            <th>Acciones
                                <button type="button" class="btn btn-secondary" id="add-servicio">Agregar Servicio</button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select class="form-select" name="servicios[0][id]">
                                    @foreach ($servicios as $servicio)
                                        <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><textarea class="form-control" name="servicios[0][notas]"></textarea></td>
                            <td><button type="button" class="btn btn-danger remove-servicio">Eliminar</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="form-group">
            <div class="form-item">
                <label for="notas" class="form-label">Notas</label>
                <textarea class="form-control" id="notas" name="notas"></textarea>
            </div>
        </div>
        <div class="button-container">
            <button type="submit" class="button">Guardar Consulta</button>
        </div>
    </form>
</div>

<script>
    document.getElementById('add-medicamento').addEventListener('click', function() {
        const table = document.getElementById('medicamentos-table').getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length;
        const row = table.insertRow(rowCount);
        row.innerHTML = `
            <td><input type="text" class="form-control" name="medicamentos[${rowCount}][nombre]" required></td>
            <td><input type="number" class="form-control" name="medicamentos[${rowCount}][cantidad]" required></td>
            <td><input type="text" class="form-control" name="medicamentos[${rowCount}][frecuencia]" required></td>
            <td><input type="text" class="form-control" name="medicamentos[${rowCount}][duracion]" required></td>
            <td><textarea class="form-control" name="medicamentos[${rowCount}][notas]"></textarea></td>
            <td><button type="button" class="btn btn-danger remove-medicamento">Eliminar</button></td>
        `;
    });

    document.getElementById('medicamentos-table').addEventListener('click', function(e) {
        if (e.target && e.target.matches('button.remove-medicamento')) {
            const row = e.target.closest('tr');
            row.parentNode.removeChild(row);
        }
    });

    document.getElementById('add-servicio').addEventListener('click', function() {
        const table = document.getElementById('servicios-table').getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length;
        const row = table.insertRow(rowCount);
        row.innerHTML = `
            <td>
                <select class="form-select" name="servicios[${rowCount}][id]">
                    @foreach ($servicios as $servicio)
                        <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>
                    @endforeach
                </select>
            </td>
            <td><textarea class="form-control" name="servicios[${rowCount}][notas]"></textarea></td>
            <td><button type="button" class="btn btn-danger remove-servicio">Eliminar</button></td>
        `;
    });

    document.getElementById('servicios-table').addEventListener('click', function(e) {
        if (e.target && e.target.matches('button.remove-servicio')) {
            const row = e.target.closest('tr');
            row.parentNode.removeChild(row);
        }
    });
</script>
@endsection

<style>
.custom-form {
    background-color: #fff; 
    padding: 2rem; 
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); 
    width: 90%; 
    max-width: 1200px; 
    margin: 2rem auto; 
}

.custom-form h3 {
    text-align: center;
    padding-bottom: 15px;
}

.custom-form label {
    display: block; 
    margin-bottom: 0.5rem; 
    font-weight: 400; 
    font-size: 13px;
}

.custom-form input[type="text"],
.custom-form input[type="email"],
.custom-form input[type="number"],
.custom-form input[type="date"],
.custom-form input[type="time"],
.custom-form input[type="password"],
.custom-form textarea, 
.custom-form select {
    width: 100%;
    border: 1px solid #d1d5db; 
    border-radius: 4px; 
    padding: 0.5rem;
}

.custom-form input:focus,
.custom-form select:focus,
.custom-form textarea:focus {
    border-color: #48bfe3; 
    outline: none;
}

.custom-form .button-container {
    display: flex;
    justify-content: center;
}

.custom-form button {
    width: 100%; 
    padding: 0.75rem; 
    background-color: #48bfe3; 
    color: #fff; 
    border: none; 
    border-radius: 4px; 
    font-weight: 600; 
    cursor: pointer; 
    transition: background-color 0.2s;
}

.custom-form button:hover {
    background-color: #4ea8de; 
}

.custom-form .form-group {
    display: flex;
    gap: 1rem; 
}

.custom-form .form-group .form-item {
    flex: 1;
}

.table th, .table td {
    padding: 0.75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}

.table .table {
    background-color: #fff;
}

.btn-secondary {
    background-color: #6c757d; 
    border: none; 
    padding: 10px 20px; 
    color: #fff; 
    cursor: pointer; 
    border-radius: 4px; 
    margin-top: 10px; 
}

.btn-danger {
    background-color: #dc3545; 
    border: none; 
    padding: 10px 20px; 
    color: #fff; 
    cursor: pointer; 
    border-radius: 4px; 
    margin-top: 10px; 
}

.button {
    background-color: #007bff;
    border: none;
    color: white;
    padding: 10px 10px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
    cursor: pointer;
    border-radius: 4px;
    margin-left: 10px;
    margin-top: 10px;
}
</style>
