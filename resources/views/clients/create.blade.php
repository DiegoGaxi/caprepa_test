@extends('layouts.prestamos')

@section('content')
    <a href="{{ url()->previous() }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded ml-2">Volver</a>
    <h1>Crear Nuevo Cliente</h1>

    <form action="{{ route('clients.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nombre:</label>
            <input type="text" name="name" id="name" class="form-input rounded-md shadow-sm w-full" value="{{ old('name') }}" required>
            @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear Cliente</button>
    </form>
@endsection
