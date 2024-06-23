<!-- resources/views/loan_amounts/index.blade.php -->

@extends('layouts.prestamos')

@section('content')
   <div class="flex justify-start">
        <a href="{{ route('loans.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded ml-2">Volver al Registro de Prestamos</a>
    </div>

    <h1>Listado de Montos de Préstamo</h1>

   <div class="flex justify-end">
        <a href="{{ route('loan_amounts.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">
            Nuevo Monto de Préstamo
        </a>
    </div>

    @if ($montosPrestamo->count() > 0)
        <table class="min-w-full divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left uppercase">Monto</th>
                    <th class="text-left uppercase">Plazo</th>
                    <th class="text-left uppercase text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($montosPrestamo as $monto)
                    <tr>
                        <td class="whitespace-nowrap">${{ $monto->amount }}</td>
                        <td class="whitespace-nowrap">{{ $monto->term }}</td>
                        <td class="whitespace-nowrap text-center">
                            <a href="{{ route('loan_amounts.show', $monto) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                            <a href="{{ route('loan_amounts.edit', $monto) }}" class="text-yellow-600 hover:text-yellow-900 mx-2">Editar</a>
                            <form action="{{ route('loan_amounts.destroy', $monto) }}" method="POST" class="inline">
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
        <p>No hay montos de préstamo registrados.</p>
    @endif
@endsection
