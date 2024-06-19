<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #e9f5ff;
        }
        .header {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header .logo {
            font-size: 24px;
            font-weight: bold;
        }
        .header .dropdown {
            position: relative;
        }
        .header .dropdown button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }
        .header .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            z-index: 1;
        }
        .header .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .header .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .header .dropdown:hover .dropdown-content {
            display: block;
        }
        .nav {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            padding: 10px 0;
        }
        .nav a {
            margin: 0 15px;
            color: #007bff;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }
        .nav a:hover {
            color: #0056b3;
        }
        .content {
            padding: 40px;
            text-align: center;
        }
        h2 {
            color: #007bff;
            font-size: 36px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">U-Medic</div>
        <div class="dropdown">
            <button>Cuenta</button>
            <div class="dropdown-content">
                <a href="{{ route('profile.edit') }}">Ver Perfil</a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
    <div class="nav">
        <a href="{{ route('dashboard') }}">Inicio</a>
        <a href="{{ route('doctores.index') }}">Médicos</a>
        <a href="{{ route('secretarias.index') }}">Secretarias</a>
        <a href="{{ route('citas.index') }}">Citas</a>
        <a href="{{ route('pacientes.index') }}">Pacientes</a>
    </div>
    <div class="content">
        <h2>Bienvenido al Dashboard</h2>
        <p>Selecciona una opción del menú para comenzar.</p>
    </div>
</body>
</html>
