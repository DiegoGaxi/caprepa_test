<!-- resources/views/loanamounts/edit.blade.php -->

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
            <label for="term" class="block text-gray-700 font-bold mb-2">Plazo (en meses):</label>
            <input type="number" name="term" id="term" class="form-input rounded-md shadow-sm w-full" value="{{ $montoPrestamo->term }}" required>
        </div>
        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Actualizar Monto de Préstamo</button>
    </form>
@endsection
