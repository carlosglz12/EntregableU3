@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Consulta para {{ $consulta->paciente->nombres }} {{ $consulta->paciente->apellidos }}</h2>

    <form method="POST" action="{{ route('consultas.update', $consulta->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="peso" class="form-label">Peso</label>
            <input type="number" step="0.01" class="form-control" id="peso" name="peso" value="{{ $consulta->peso }}" required>
        </div>
        <div class="mb-3">
            <label for="talla" class="form-label">Talla</label>
            <input type="number" step="0.01" class="form-control" id="talla" name="talla" value="{{ $consulta->talla }}" required>
        </div>
        <div class="mb-3">
            <label for="temperatura" class="form-label">Temperatura</label>
            <input type="number" step="0.1" class="form-control" id="temperatura" name="temperatura" value="{{ $consulta->temperatura }}" required>
        </div>
        <div class="mb-3">
            <label for="saturacion" class="form-label">Saturación</label>
            <input type="number" step="0.1" class="form-control" id="saturacion" name="saturacion" value="{{ $consulta->saturacion }}" required>
        </div>
        <div class="mb-3">
            <label for="frecuencia_cardiaca" class="form-label">Frecuencia Cardíaca</label>
            <input type="number" class="form-control" id="frecuencia_cardiaca" name="frecuencia_cardiaca" value="{{ $consulta->frecuencia_cardiaca }}" required>
        </div>
        <div class="mb-3">
            <label for="altura" class="form-label">Altura</label>
            <input type="number" step="0.01" class="form-control" id="altura" name="altura" value="{{ $consulta->altura }}" required>
        </div>
        <div class="mb-3">
            <label for="motivo_consulta" class="form-label">Motivo de la Consulta</label>
            <textarea class="form-control" id="motivo_consulta" name="motivo_consulta" required>{{ $consulta->motivo_consulta }}</textarea>
        </div>
        <div class="mb-3">
            <label for="padecimiento" class="form-label">Padecimiento</label>
            <textarea class="form-control" id="padecimiento" name="padecimiento" required>{{ $consulta->padecimiento }}</textarea>
        </div>
        <div class="mb-3">
            <label for="medicamentos" class="form-label">Medicamentos</label>
            <div id="medicamentos-container">
                @foreach (json_decode($consulta->medicamentos, true) as $index => $medicamento)
                    <div class="medicamento">
                        <input type="text" class="form-control mb-2" name="medicamentos[{{ $index }}][nombre]" placeholder="Nombre" value="{{ $medicamento['nombre'] }}" required>
                        <input type="number" class="form-control mb-2" name="medicamentos[{{ $index }}][cantidad]" placeholder="Cantidad" value="{{ $medicamento['cantidad'] }}" required>
                        <input type="text" class="form-control mb-2" name="medicamentos[{{ $index }}][frecuencia]" placeholder="Frecuencia" value="{{ $medicamento['frecuencia'] }}" required>
                        <input type="text" class="form-control mb-2" name="medicamentos[{{ $index }}][duracion]" placeholder="Duración" value="{{ $medicamento['duracion'] }}" required>
                        <textarea class="form-control mb-2" name="medicamentos[{{ $index }}][notas]" placeholder="Notas">{{ $medicamento['notas'] }}</textarea>
                        <button type="button" class="btn btn-danger" onclick="removeMedicamento(this)">Eliminar</button>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-secondary" onclick="addMedicamento()">Agregar Medicamento</button>
        </div>
        <div class="mb-3">
            <label for="servicios" class="form-label">Servicios</label>
            <select class="form-select" id="servicios" name="servicios[]" multiple required>
                @foreach ($servicios as $servicio)
                    <option value="{{ $servicio->id }}" {{ in_array($servicio->id, $consulta->servicios->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $servicio->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="notas" class="form-label">Notas</label>
            <textarea class="form-control" id="notas" name="notas">{{ $consulta->notas }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar Consulta</button>
    </form>
</div>

<script>
    function addMedicamento() {
        const container = document.getElementById('medicamentos-container');
        const index = container.children.length;
        const div = document.createElement('div');
        div.classList.add('medicamento');
        div.innerHTML = `
            <input type="text" class="form-control mb-2" name="medicamentos[${index}][nombre]" placeholder="Nombre" required>
            <input type="number" class="form-control mb-2" name="medicamentos[${index}][cantidad]" placeholder="Cantidad" required>
            <input type="text" class="form-control mb-2" name="medicamentos[${index}][frecuencia]" placeholder="Frecuencia" required>
            <input type="text" class="form-control mb-2" name="medicamentos[${index}][duracion]" placeholder="Duración" required>
            <textarea class="form-control mb-2" name="medicamentos[${index}][notas]" placeholder="Notas"></textarea>
            <button type="button" class="btn btn-danger" onclick="removeMedicamento(this)">Eliminar</button>
        `;
        container.appendChild(div);
    }

    function removeMedicamento(button) {
        button.parentElement.remove();
    }
</script>
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

.form-label {
    font-weight: bold; 
    margin-bottom: 0.5rem; 
}

.form-control {
    margin-bottom: 1rem; 
    border-radius: 4px; 
}

.btn-primary {
    background-color: #007bff; 
    border: none; 
    padding: 10px 20px; 
    color: #fff; 
    cursor: pointer; 
    border-radius: 4px; 
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

#medicamentos-container .medicamento {
    display: flex; 
    flex-wrap: wrap; 
    gap: 1rem; 
    margin-bottom: 1rem; 
}
</style>
