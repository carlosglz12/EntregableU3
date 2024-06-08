@extends('layouts.app')

@section('content')
<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Nombres
                </th>
                <th scope="col" class="px-6 py-3">
                    Apellidos
                </th>
                <th scope="col" class="px-6 py-3">
                    Correo
                </th>
                <th scope="col" class="px-6 py-3">
                    Teléfono
                </th>
                <th scope="col" class="px-6 py-3">
                    Dirección
                </th>
                <th scope="col" class="px-6 py-3">
                    Edad
                </th>
                <th scope="col" class="px-6 py-3">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pacientes as $paciente)
            <tr class="bg-white border-b">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ $paciente->nombres }}
                </th>
                <td class="px-6 py-4">
                    {{ $paciente->apellidos }}
                </td>
                <td class="px-6 py-4">
                    {{ $paciente->correo }}
                </td>
                <td class="px-6 py-4">
                    {{ $paciente->telefono }}
                </td>
                <td class="px-6 py-4">
                    {{ $paciente->direccion }}
                </td>
                <td class="px-6 py-4">
                    {{ $paciente->edad }}
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('pacientes.edit', $paciente->id) }}" class="text-blue-600 hover:underline">Editar</a>
                    <form action="{{ route('pacientes.destroy', $paciente->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
