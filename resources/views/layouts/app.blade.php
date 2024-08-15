<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
       <!-- @if(Auth::check())
         <p>Current role: {{ Auth::user()->role->name }}</p>-->
            @if(Auth::user()->role->name === 'Administrador')
                @include('layouts.navigation')
            @elseif(Auth::user()->role->name === 'Doctor')
                @include('layouts.navigationdoctor')
            @elseif(Auth::user()->role->name === 'Secretaria')
                @include('layouts.navigationsecretaria')
            @else
                @include('layouts.navigation')
            @endif
        @else
            @include('layouts.navigation')
        @endif
        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset
        @stack('scripts')
        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Abrir y cerrar la ventana modal
            var modal = document.getElementById("myModal");
            var btn = document.getElementById("myBtn");
            var span = document.getElementsByClassName("close")[0];

            if (btn) {
                btn.onclick = function () {
                    modal.style.display = "block";
                }

                span.onclick = function () {
                    modal.style.display = "none";
                }

                window.onclick = function (event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
            }
        });
    </script>
</body>
</html>
