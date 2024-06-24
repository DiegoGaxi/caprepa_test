@extends('layouts.prestamos')

@section('content')

   <div class="flex justify-start mb-8">
      <a href="{{ route('clients.index') }}" class="bg-blue-300 hover:bg-blue-400 font-bold py-2 px-4 rounded mr-2">Catálogo Clientes</a>
      <a href="{{ route('loan_amounts.index') }}" class="bg-green-300 hover:bg-green-400 font-bold py-2 px-4 rounded mr-2">Catálogo Montos</a>
   </div>

   <h1 class="text-2xl font-semibold mb-8">Registro de Préstamos</h1>

   <a href="{{ route('loans.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded mb-8">Agregar Préstamo</a>

   <div class="mt-4">
      <form action="{{ route('loans.index') }}" method="GET">
         <input type="text" name="filter" placeholder="Buscar por cliente, monto o plazo..." class="border px-4 py-2 rounded">
         <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded mt-4">Buscar</button>
      </form>
   </div>

   <div class="mt-4">
      <input type="text" id="filterInput" placeholder="Filtrado rapido" class="w-full border px-4 py-2 rounded">
   </div>

   <table class="min-w-full mt-4 text-center" id="loansTable">
      <thead>
         <tr>
            <th class="px-6 py-2">Cliente</th>
            <th class="px-6 py-2">Monto del préstamo</th>
            <th class="px-6 py-2">Plazos</th>
            <th class="px-6 py-2">Amortizacion</th>
         </tr>
      </thead>
      <tbody>
         @foreach($loans as $loan)
            <tr>
               <td class="px-6 py-2">{{ $loan->client->name }}</td>
               <td class="px-6 py-2">${{ $loan->loanAmount->amount }}</td>
               <td class="px-6 py-2">{{ $loan->loan_amount_term->term->term }}</td>
               <td class="px-6 py-2">
                  <a href="{{ route('loans.show', $loan->id) }}" class="amortizacion"></a>
               </td>
            </tr>
         @endforeach
      </tbody>
   </table>

   <script>
      document.getElementById('filterInput').addEventListener('keyup', function() {
         var input, filter, table, tr, td, i, txtValue;
         input = document.getElementById("filterInput");
         filter = input.value.toUpperCase();
         table = document.getElementById("loansTable");
         tr = table.getElementsByTagName("tr");

         for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td");
            let found = false;
            for (let j = 0; j < td.length; j++) {
               txtValue = td[j].textContent || td[j].innerText;
               if (txtValue.toUpperCase().indexOf(filter) > -1) {
                  found = true;
               }
            }
            if (found) {
               tr[i].style.display = "";
            } else {
               tr[i].style.display = "none";
            }
         }
      });
   </script>

@endsection
