@extends('layouts.prestamos')

@section('content')
    <div class="flex justify-start">
        <a href="{{ url()->previous() }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded ml-2">Volver</a>
    </div>

    <h1>Detalles del Préstamo</h1>

    <p><strong>Cliente:</strong> {{ $loan->client->name }}</p>
    <p><strong>Monto del Préstamo:</strong> {{ $loan->loanAmount->amount }}</p>
    <p><strong>Plazo:</strong> {{ $loan->loanAmount->term }} meses</p>

    <div class="mt-8">

        <h2>Tabla de Amortización</h2>

        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">No. Pago</th>
                    <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">Préstamo</th>
                    <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">Interés</th>
                    <th class="px-6 py-3 text-left text-xs text-gray-600 uppercase tracking-wider">Abono</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($amortizationSchedule['schedule'] as $payment)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $payment['installment'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $payment['payment_date']->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($payment['payment_amount'], 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($payment['interest'], 2) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">${{ number_format($payment['principal'], 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="1"></td>
                    <td class="px-6 py-4 whitespace-nowrap"><strong>Totales:</strong></td>
                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($amortizationSchedule['totals']['total_payment'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($amortizationSchedule['totals']['total_interest'], 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($amortizationSchedule['totals']['total_principal'], 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
