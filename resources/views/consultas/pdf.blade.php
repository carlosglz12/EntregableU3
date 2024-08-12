<!DOCTYPE html>
<html>
<head>
    <title>Consulta #{{ $consulta->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }
        .header, .footer {
            text-align: center;
        }
        .content {
            margin: 20px;
        }
        .details {
            margin-bottom: 20px;
        }
        .details p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Detalles de la Consulta</h2>
    </div>
    <div class="content">
        <div class="details">
            <p><strong>Paciente:</strong> {{ $consulta->paciente->nombres }} {{ $consulta->paciente->apellidos }}</p>
            <p><strong>Fecha:</strong> {{ $consulta->created_at->format('d/m/Y') }}</p>
            <p><strong>Peso:</strong> {{ $consulta->peso }} kg</p>
            <p><strong>Talla:</strong> {{ $consulta->talla }} cm</p>
            <p><strong>Temperatura:</strong> {{ $consulta->temperatura }} °C</p>
            <p><strong>Saturación:</strong> {{ $consulta->saturacion }} %</p>
            <p><strong>Frecuencia Cardíaca:</strong> {{ $consulta->frecuencia_cardiaca }} bpm</p>
            <p><strong>Altura:</strong> {{ $consulta->altura }} cm</p>
            <p><strong>Motivo de la Consulta:</strong> {{ $consulta->motivo_consulta }}</p>
            <p><strong>Padecimiento:</strong> {{ $consulta->padecimiento }}</p>
        </div>
        <div class="details">
            <p><strong>Medicamentos:</strong></p>
            <ul>
                @foreach (json_decode($consulta->medicamentos, true) as $medicamento)
                    <li>{{ $medicamento['nombre'] }} - {{ $medicamento['cantidad'] }} ({{ $medicamento['frecuencia'] }}), {{ $medicamento['duracion'] }}</li>
                @endforeach
            </ul>
        </div>
        <div class="details">
            <p><strong>Notas:</strong> {{ $consulta->notas }}</p>
        </div>
    </div>
    <div class="footer">
        <p>Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
