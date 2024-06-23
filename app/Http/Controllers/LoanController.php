<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Loan;
use App\Models\LoanAmount;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with('client', 'loanAmount')->get();
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $clients = Client::all();
        $loanAmounts = LoanAmount::all()->groupBy('amount'); // Agrupar por cantidad de préstamo
        $termsByAmount = $this->getTermsByLoanAmounts($loanAmounts); // Obtener términos por cantidad de préstamo
        return view('loans.create', compact('clients', 'loanAmounts', 'termsByAmount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'loan_amount_id' => 'required|exists:loan_amounts,id',
            'term' => 'required|numeric|min:1', // Validar que el plazo sea un número positivo
        ]);

        Loan::create($request->all());

        return redirect()->route('loans.index');
    }

    private function getTermsByLoanAmounts($loanAmounts)
    {
      $termsByAmount = $loanAmounts->mapWithKeys(function ($items) {
         return [$items->first()->id => $items->pluck('term')];
      })->toArray();

      return $termsByAmount;
    }

    public function show($id)
    {
        $loan = Loan::with('client', 'loanAmount')->findOrFail($id);
        $amortizationSchedule = $this->generateAmortizationSchedule($loan);
        return view('loans.show', compact('loan', 'amortizationSchedule'));
    }

    private function generateAmortizationSchedule($loan)
      {
         $schedule = [];
         $remainingAmount = $loan->loanAmount->amount;
         $term = $loan->loanAmount->term;
         $interestRate = 11; // Tasa de interés mensual

         $paymentAmount = $remainingAmount / $term;

         $totalPayment = 0;
         $totalInterest = 0;
         $totalPrincipal = 0;

         $currentDate = \Carbon\Carbon::now();

         for ($i = 1; $i <= $term; $i++) {

            // Calcular principal para este pago
            $principal = $paymentAmount + $interestRate;

            // Ajustar la fecha al próximo día 15 o final del mes siguiente
            if ($currentDate->day <= 15) {
                  $paymentDate = $currentDate->copy()->addDays(15 - $currentDate->day);
            } else {
                  $paymentDate = $currentDate->copy()->endOfMonth();
            }

            $schedule[] = [
                  'installment' => $i,
                  'payment_amount' => $paymentAmount,
                  'interest' => $interestRate,
                  'principal' => $principal,
                  'payment_date' => $paymentDate,
            ];

            // Actualizar totales
            $totalPayment += $paymentAmount;
            $totalInterest += $interestRate;
            $totalPrincipal += $principal;

            // Actualizar fecha actual para el próximo cálculo
            $currentDate = $paymentDate->copy()->addDay();

            // Actualizar monto restante después de deducir el principal
         }

         return [
            'schedule' => $schedule,
            'totals' => [
                  'total_payment' => $totalPayment,
                  'total_interest' => $totalInterest,
                  'total_principal' => $totalPrincipal,
            ],
         ];
      }

}
