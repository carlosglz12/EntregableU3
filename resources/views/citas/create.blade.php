@extends('layouts.app')

@section('title', 'Agendar Cita')

@section('content')
<form class="max-w-md mx-auto" method="POST" action="{{ route('citas.store') }}">
    @csrf
    <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

    <div class="mb-5">
        <label for="nombres" class="block mb-2 text-sm font-medium text-gray-900">Nombres</label>
        <input type="text" id="nombres" name="nombres" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ $paciente->nombres }}" readonly />
    </div>

    <div class="mb-5">
        <label for="apellidos" class="block mb-2 text-sm font-medium text-gray-900">Apellidos</label>
        <input type="text" id="apellidos" name="apellidos" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ $paciente->apellidos }}" readonly />
    </div>

    <div class="mb-5">
        <label for="correo" class="block mb-2 text-sm font-medium text-gray-900">Correo</label>
        <input type="email" id="correo" name="correo" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ $paciente->correo }}" readonly />
    </div>

    <div class="mb-5">
        <label for="telefono" class="block mb-2 text-sm font-medium text-gray-900">Teléfono</label>
        <input type="text" id="telefono" name="telefono" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" value="{{ $paciente->telefono }}" readonly />
    </div>

    <div class="mb-5">
        <label for="fecha_hora" class="block mb-2 text-sm font-medium text-gray-900">Fecha y Hora</label>
        <input type="datetime-local" id="fecha_hora" name="fecha_hora" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
    </div>

    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Agendar</button>
</form>
@endsection
