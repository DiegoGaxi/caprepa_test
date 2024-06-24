@extends('layouts.prestamos')

@section('content')
    <div class="flex justify-start">
        <a href="{{ route('loans.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded ml-2">Volver al Registro de Prestamos</a>
    </div>

    <h1>Listado de Clientes</h1>

    <div class="flex justify-end">
        <a href="{{ route('clients.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">
            Nuevo Cliente
        </a>
    </div>

    @if ($clients->count() > 0)
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($clients as $cliente)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $cliente->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <a href="{{ route('clients.show', $cliente) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                            <a href="{{ route('clients.edit', $cliente) }}" class="text-yellow-600 hover:text-yellow-900 mx-2">Editar</a>
                            <form action="{{ route('clients.destroy', $cliente) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay clientes registrados.</p>
    @endif
@endsection
