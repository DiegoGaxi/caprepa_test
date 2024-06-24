@extends('layouts.prestamos')

@section('content')
    <div class="flex justify-start">
        <a href="{{ url()->previous() }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded ml-2">Volver</a>
    </div>
    
    <h1>Editar Monto de Préstamo</h1>

    <form action="{{ route('loan_amounts.update', $montoPrestamo) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="amount" class="block text-gray-700 font-bold mb-2">Monto:</label>
            <input type="number" name="amount" id="amount" class="form-input rounded-md shadow-sm w-full" value="{{ $montoPrestamo->amount }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Plazos (en quincenas):</label>
            @foreach($terms as $term)
                <div class="flex items-center">
                    <input type="checkbox" name="term_ids[]" id="term_{{ $term->id }}" value="{{ $term->id }}" class="form-checkbox h-5 w-5 text-blue-600"
                        @if($montoPrestamo->loan_amount_terms->contains('term_id', $term->id)) checked @endif>
                    <label for="term_{{ $term->id }}" class="ml-2">{{ $term->term }}</label>
                </div>
            @endforeach
        </div>
            @error('amount')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
            @error('term_ids')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
            @error('term_ids.*')
                <div class="text-red-500">{{ $message }}</div>
            @enderror
        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Actualizar Monto de Préstamo</button>
    </form>
@endsection
