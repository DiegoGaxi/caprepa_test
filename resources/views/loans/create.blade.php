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
                @foreach($loanAmounts as $amount => $items)
                    <option value="{{ $items->first()->id }}">{{ $amount }}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-4">
            <label for="term" class="block">Plazo (en quincenas)</label>
            <select name="term" id="term" class="w-full border px-4 py-2 rounded">
                <!-- Opciones de plazo se llenan dinámicamente según el monto seleccionado -->
            </select>
            <?php echo "<pre>" . print_r($termsByAmount, true) . "</pre>"; ?>
        </div>
        <div class="mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Agregar Préstamo</button>
            <a href="{{ route('loans.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Cancelar</a>
        </div>
    </form>

    <script>
        // Variables con opciones de términos según el monto seleccionado
        var termsByAmount = @json($termsByAmount);
        
        // Función para actualizar las opciones de plazo según el monto seleccionado
        function updateTermOptions() {
            var loanAmountId = document.getElementById('loan_amount_id').value;

            // Limpiar opciones actuales
            var termSelect = document.getElementById('term');
            termSelect.innerHTML = '';

            // Verificar si existen términos para el monto seleccionado
            if (termsByAmount.hasOwnProperty(loanAmountId)) {
                // Llenar select con las nuevas opciones
                termsByAmount[loanAmountId].forEach(function (term) {
                    var option = document.createElement('option');
                    option.value = term;
                    option.textContent = term + ' quincenas';
                    termSelect.appendChild(option);
                });
            }
        }

        // Llamar a la función inicialmente para cargar las opciones de plazo según el primer monto disponible
        updateTermOptions();
    </script>
@endsection
