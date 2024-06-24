@extends('layouts.prestamos')

@section('content')
    <div class="flex justify-start">
        <a href="{{ url()->previous() }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded ml-2">Volver</a>
    </div>
    
    <h1>Crear Nuevo Monto de Préstamo</h1>

    <form action="{{ route('loan_amounts.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="amount" class="block text-gray-700 font-bold mb-2">Monto:</label>
            <input type="number" name="amount" id="amount" class="form-input rounded-md shadow-sm w-full" value="{{ old('amount') }}" required>
            @error('amount')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Plazos (en meses):</label>
            @foreach($terms as $term)
                <div class="flex items-center">
                    <input type="checkbox" name="term_ids[]" id="term_{{ $term->id }}" value="{{ $term->id }}" class="form-checkbox h-5 w-5 text-blue-600">
                    <label for="term_{{ $term->id }}" class="ml-2">{{ $term->term }}</label>
                </div>
            @endforeach
            @error('term_ids')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
            @error('term_ids.*')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Crear Monto de Préstamo</button>
    </form>
@endsection
