@extends('layouts.prestamos')

@section('content')

    <div class="flex justify-start">
        <a href="{{ url()->previous() }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded ml-2">Volver</a>
    </div>
    
    <h1>Detalles del Monto de Préstamo</h1>

    <p><strong>Monto:</strong> ${{ $montoPrestamo->amount }}</p>
    <p><strong>Plazo:</strong> {{ $montoPrestamo->term }} Pagos</p>

    <div class="flex justify-end">
        <a href="{{ route('loan_amounts.edit', $montoPrestamo) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded mt-3">Editar Monto de Préstamo</a>
    </div>
@endsection
