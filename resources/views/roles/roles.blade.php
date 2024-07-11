@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Roles</h2>
    <a href="{{ route('roles.create') }}" class="btn btn-primary">Crear Role</a>

    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-2">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered mt-2">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        @foreach ($roles as $role)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $role->name }}</td>
            <td>
                <a class="btn btn-info" href="{{ route('roles.index', $role->id) }}">Ver</a>
                <a class="btn btn-primary" href="{{ route('roles.edit', $role->id) }}">Editar</a>
                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection
