@extends('layouts.prestamos')

@section('content')
    <h1 class="text-2xl font-semibold">Agregar Préstamo</h1>
    <form action="{{ route('loans.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="mt-4">
            <label for="client_id" class="block">Cliente</label>
            <select name="client_id" id="client_id" class="w-full border px-4 py-2 rounded">
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-4">
            <label for="loan_amount_id" class="block">Monto del Préstamo</label>
            <select name="loan_amount_id" id="loan_amount_id" class="w-full border px-4 py-2 rounded" onchange="updateTermOptions()">
                @foreach($loanAmounts as $amount)
                    <option value="{{ $amount->id }}">{{ $amount->amount }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-4">
            <label for="loan_amount_term_id" class="block">Plazo (en quincenas)</label>
            <select name="loan_amount_term_id" id="loan_amount_term_id" class="w-full border px-4 py-2 rounded">
                <!-- Opciones de plazo se llenan dinámicamente según el monto seleccionado -->
            </select>
        </div>
        <div class="mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Agregar Préstamo</button>
            <a href="{{ route('loans.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
        </div>
    </form>

    <script>
        // Variables con opciones de plazos según el monto seleccionado
        var termsByAmount = @json($termsByAmount);
        
        // Función para actualizar las opciones de plazo según el monto seleccionado
        function updateTermOptions() {
            var loanAmountId = document.getElementById('loan_amount_id').value;
            var termSelect = document.getElementById('loan_amount_term_id');
            termSelect.innerHTML = '';

            // Verificar si existen plazos para el monto seleccionado
            if (termsByAmount.hasOwnProperty(loanAmountId)) {
                // Llenar select con las nuevas opciones
                Object.keys(termsByAmount[loanAmountId]).forEach(function (termId) {
                    var option = document.createElement('option');
                    console.log(loanAmountId);
                    console.log(termId);
                    console.log(termsByAmount[loanAmountId][termId]);
                    option.value = termId; // Valor del option es el id del plazo
                    option.textContent = termsByAmount[loanAmountId][termId].term + ' quincenas'; // Texto del option es el plazo más 'quincenas'
                    termSelect.appendChild(option);
                });
            }
        }

        // Llamar a la función inicialmente para cargar las opciones de plazo según el primer monto disponible
        updateTermOptions();
    </script>
@endsection
