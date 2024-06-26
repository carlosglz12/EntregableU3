<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar Sesión</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #007bff 0%, #6667ab 100%);
        }
        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }
        input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .button {
            background-color: #000;
            border: none;
            color: white;
            padding: 12px;
            text-align: center;
            text-decoration: none;
            display: block;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            width: 100%;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #333;
        }
        .forgot-password {
            margin-top: 20px;
            display: block;
            font-size: 14px;
            color: #666;
            text-decoration: none;
        }
        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Inicia Sesión</h2>
        @if (Route::has('login'))
            <div>
                @auth
                    <a href="{{ url('/dashboard') }}" class="button">Dashboard</a>
                @else
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input type="email" name="email" placeholder="Email" required><br>
                        <input type="password" name="password" placeholder="Contraseña" required><br>
                        <button class="button" type="submit">Iniciar Sesión</button>
                    </form>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="forgot-password">¿No tienes una cuenta? Regístrate</a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
</body>
</html>
