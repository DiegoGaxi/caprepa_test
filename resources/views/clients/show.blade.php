@extends('layouts.prestamos')

@section('content')
    <div class="flex justify-start">
        <a href="{{ route('clients.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded ml-2">Volver</a>
    </div>

    <h1>Detalles del Cliente</h1>

    <div class="flex justify-end">
        <a href="{{ route('clients.edit', $cliente) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Editar Cliente</a>
    </div>
    
    <div class="mb-4">
        <p><strong>Nombre:</strong> {{ $cliente->name }}</p>
    </div>
@endsection
