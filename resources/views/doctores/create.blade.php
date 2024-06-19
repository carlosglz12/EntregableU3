@extends('layouts.app')

@section('content')
<form class="max-w-sm mx-auto" method="POST" action="{{ route('doctores.store') }}">
    @csrf
    <!--Nombres-->
    <div class="mb-5">
        <label for="nombres" class="block mb-2 text-sm font-medium text-white-900 dark:text-black">Nombres</label>
        <input type="text" id="nombres" name="nombres" class="shadow-sm bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="" required />
    </div>

    <!--Apellidos-->
    <div class="mb-5">
        <label for="apellidos" class="block mb-2 text-sm font-medium text-white-900 dark:text-black">Apellidos</label>
        <input type="text" id="apellidos" name="apellidos" class="shadow-sm bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="" required />
    </div>

    <!--Email-->
    <div class="mb-5">
        <label for="email" class="block mb-2 text-sm font-medium text-white-900 dark:text-black">Correo</label>
        <input type="email" id="email" name="correo" class="shadow-sm bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="" required />
    </div>

    <!--password-->
    <div class="mb-5">
        <label for="password" class="block mb-2 text-sm font-medium text-white-900 dark:text-black">Contraseña</label>
        <input type="password" id="password" name="password" class="shadow-sm bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
    </div>

    <!--repeat password-->
    <div class="mb-5">
        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-white-900 dark:text-black">Confirmar contraseña</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="shadow-sm bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
    </div>

    <!--telefono-->
    <div class="mb-5">
        <label for="telefono" class="block mb-2 text-sm font-medium text-white-900 dark:text-black">Telefono</label>
        <input type="tel" id="telefono" name="telefono" class="shadow-sm bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="" required />
    </div>
    
    <!--especialidad-->
    <div class="mb-5">
        <label for="especialidad" class="block mb-2 text-sm font-medium text-white-900 dark:text-black">Especialidad</label>
        <input type="text" id="especialidad" name="especialidad" class="shadow-sm bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="" required />
    </div>
    
    <!--consultorio-->
    <div class="mb-5">
        <label for="consultorio" class="block mb-2 text-sm font-medium text-white-900 dark:text-black">Consultorio</label>
        <input type="tel" id="consultorio" name="consultorio" class="shadow-sm bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" placeholder="" required />
    </div>    

    <button type="submit" class="text-black bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar</button>
</form>
@endsection
