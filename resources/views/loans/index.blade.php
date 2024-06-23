@extends('layouts.prestamos')

@section('content')

   <div class="flex justify-start">
      <a href="{{ route('clients.index') }}" class="bg-blue-300 hover:bg-blue-400 text-blue-800 font-bold py-2 px-4 rounded ml-2">Catalogo Clientes</a>
      <a href="{{ route('loan_amounts.index') }}" class="bg-green-300 hover:bg-green-400 text-green-800 font-bold py-2 px-4 rounded ml-2">Catalogo Montos</a>
    </div>

    <h1 class="text-2xl font-semibold mb-4">Registro de Prestamos</h1>
    <a href="{{ route('loans.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Agregar Préstamo</a>
    <table class="min-w-full mt-4 text-center">
        <thead>
            <tr>
                <th class="px-6 py-2">Cliente</th>
                <th class="px-6 py-2">Monto del préstamo</th>
                <th class="px-6 py-2">Plazos</th>
                <th class="px-6 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loans as $loan)
                <tr>
                    <td class="px-6 py-2">{{ $loan->client->name }}</td>
                    <td class="px-6 py-2">${{ $loan->loanAmount->amount }}</td>
                    <td class="px-6 py-2">{{ $loan->loanAmount->term }}</td>
                    <td class="px-6 py-2">
                        <a href="{{ route('loans.show', $loan->id) }}" class="amortizacion"></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
