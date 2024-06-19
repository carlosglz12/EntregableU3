<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrarse</title>
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
        input, select {
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
        .login-link {
            margin-top: 20px;
            display: block;
            font-size: 14px;
            color: #666;
            text-decoration: none;
        }
        .login-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Regístrate</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <input type="text" name="name" placeholder="Nombre" required>
            <input type="text" name="last_name" placeholder="Apellidos" required>
            <input type="email" name="email" placeholder="Correo" required>
            <select name="role" required>
                <option value="medico">Médico</option>
                <option value="secretaria">Secretaria</option>
            </select>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required>
            <input type="text" name="telefono" placeholder="Teléfono" required>
            <button class="button" type="submit">Registrarme</button>
        </form>
        <a href="{{ route('login') }}" class="login-link">¿Tienes una cuenta? Inicia Sesión</a>
    </div>
</body>
</html>
