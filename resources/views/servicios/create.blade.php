@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/formularios.css') }}">
@section('content')
<form class="custom-form" method="POST" action="{{ route('servicios.store') }}">
    @csrf
    <h3>Agregar Servicio</h3>
    <!--nombre y descripción-->
        <div class="form-item mb-5">
            <label for="nombre">Nombre</label>
            <input type="text" id="nombre" name="nombre" placeholder="" required />
        </div>
        <div class="form-item mb-5">
            <label for="descripcion">Descripción</label>
            <input type="text" id="descripcion" name="descripcion" placeholder="" required />
        </div>
        <div  class="form-item mb-5"">
            <label for="precio" class="block mb-2 text-sm font-medium text-white-900 dark:text-black">Precio</label>
            <input type="number" id="precio" name="precio" class="shadow-sm bg-white-50 border border-white-300 text-white-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-white-700 dark:border-white-600 dark:placeholder-white-400 dark:text-black dark:focus:ring-blue-500 dark:focus:border-blue-500 dark:shadow-sm-light" required />
        </div>
    <button type="submit" class="text-black bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Registrar</button>
</form>
@endsection