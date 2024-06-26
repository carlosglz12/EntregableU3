<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>U-Medic - Bienvenida</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #e9f5ff;
            color: #333;
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
        .header .auth-buttons a {
            margin: 0 5px;
            padding: 8px 16px;
            background-color: #343a40;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            font-size: 14px;
        }
        .header .auth-buttons a:hover {
            background-color: #495057;
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
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 120px);
            padding: 20px;
        }
        .welcome-box {
            max-width: 900px;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .welcome-text {
            max-width: 500px;
        }
        .welcome-text h1 {
            color: #007bff;
            font-size: 48px;
            margin-bottom: 20px;
        }
        .welcome-text p {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .welcome-text a {
            display: inline-block;
            padding: 12px 24px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
        }
        .welcome-text a:hover {
            background-color: #218838;
        }
        .welcome-image img {
            max-width: 350px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">U-Medic</div>
        <div class="auth-buttons">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Iniciar Sesión</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Registrarse</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
    <div class="container">
        <div class="welcome-box">
            <div class="welcome-text">
                <h1>Gestión médica fácil y eficiente</h1>
                <p>Conoce U-Medic</p>
                <a href="{{ route('register') }}">Regístrate</a>
            </div>
              <div class="welcome-image">
              <!--  <img src="{{ asset('images/wimg.png') }}" alt="Welcome Image"> -->
            </div>
        </div>
    </div>
</body>
</html>
