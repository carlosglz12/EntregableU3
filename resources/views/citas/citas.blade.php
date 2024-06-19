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
                    Fecha y Hora
                </th>
                <th scope="col" class="px-6 py-3">
                    Acciones
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citas as $cita)
            <tr class="bg-white border-b">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ $cita->paciente->nombres }}
                </th>
                <td class="px-6 py-4">
                    {{ $cita->paciente->apellidos }}
                </td>
                <td class="px-6 py-4">
                    {{ $cita->paciente->correo }}
                </td>
                <td class="px-6 py-4">
                    {{ $cita->paciente->telefono }}
                </td>
                <td class="px-6 py-4">
                    {{ $cita->paciente->direccion }}
                </td>
                <td class="px-6 py-4">
                    {{ $cita->paciente->edad }}
                </td>
                <td class="px-6 py-4">
                    {{ $cita->fecha_hora }}
                </td>
                <td class="px-6 py-4">
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
