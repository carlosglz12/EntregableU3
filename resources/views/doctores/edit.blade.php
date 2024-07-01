@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/formularios.css') }}">

@section('content')
<form class="custom-form" method="POST" action="{{ route('doctores.update', $doctor->id) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <!--Nombres-->
        <div class="form-item mb-5">
            <label for="nombres" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombres</label>
            <input type="text" id="nombres" name="nombres" value="{{ $doctor->nombres }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
        </div>

        <!--Apellidos-->
        <div class="form-item mb-5">
            <label for="apellidos" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Apellidos</label>
            <input type="text" id="apellidos" name="apellidos" value="{{ $doctor->apellidos }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
        </div>
    </div>

    <div class="form-group">
        <!--Correo-->
        <div class="form-item mb-5">
            <label for="correo" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Correo</label>
            <input type="email" id="correo" name="correo" value="{{ $doctor->correo }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
        </div>

        <!--Teléfono-->
        <div class="form-item mb-5">
            <label for="telefono" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Teléfono</label>
            <input type="tel" id="telefono" name="telefono" value="{{ $doctor->telefono }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
        </div>
    </div>

    <div class="form-group">
        <!--Especialidad-->
        <div class="form-item mb-5">
            <label for="especialidad" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Especialidad</label>
            <input type="text" id="especialidad" name="especialidad" value="{{ $doctor->especialidad }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
        </div>

        <!--Consultorio-->
        <div class="form-item mb-5">
            <label for="consultorio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Consultorio</label>
            <input type="tel" id="consultorio" name="consultorio" value="{{ $doctor->consultorio }}" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
        </div>
    </div>

    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Actualizar</button>
</form>
@endsection
