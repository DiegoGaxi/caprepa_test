@extends('layouts.prestamos')

@section('content')
    <div class="flex justify-start">
        <a href="{{ url()->previous() }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded ml-2">Volver</a>
    </div>
    
    <h1>Crear Nuevo Plazo</h1>

    <form action="{{ route('terms.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="term" class="block text-gray-700 font-bold mb-2">Plazo (quincenas):</label>
            <input type="number" name="term" id="term" class="form-input rounded-md shadow-sm w-full" value="{{ old('term') }}" required>
            @error('term')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear Plazo</button>
    </form>
@endsection
