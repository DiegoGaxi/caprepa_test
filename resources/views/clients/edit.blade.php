@extends('layouts.prestamos')

@section('content')
    <div class="flex justify-start">
        <a href="{{ route('clients.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded ml-2">Volver</a>
    </div>
    
    <h1>Editar Cliente</h1>

    <form action="{{ route('clients.update', $cliente) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nombre:</label>
            <input type="text" name="name" id="name" class="form-input rounded-md shadow-sm w-full" value="{{ $cliente->name }}" required>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Actualizar Cliente</button>
    </form>
@endsection
