<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Loan;
use App\Models\LoanAmount;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $query = Loan::query();

        if ($request->has('filter')) {
            $filter = $request->input('filter');
            $query->whereHas('client', function ($q) use ($filter) {
                $q->where('name', 'like', '%' . $filter . '%');
            })->orWhereHas('loanAmount', function ($q) use ($filter) {
                $q->where('amount', 'like', '%' . $filter . '%');
            })->orWhereHas('loan_amount_term', function ($q) use ($filter) {
                $q->whereHas('term', function ($qq) use ($filter) {
                    $qq->where('term', 'like', '%' . $filter . '%');
                });
            });
        }

        $loans = $query->with('client', 'loanAmount', 'loan_amount_term.term')->get();

        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $clients = Client::all();
        $loanAmounts = LoanAmount::with('loan_amount_terms')->get(); // Obtener todos los montos de préstamo con sus términos
        $termsByAmount = $this->getTermsByLoanAmounts($loanAmounts); // Obtener términos por cantidad de préstamo
        return view('loans.create', compact('clients', 'loanAmounts', 'termsByAmount'));
    }

    private function getTermsByLoanAmounts($loanAmounts)
    {
        $termsByAmount = [];

        foreach ($loanAmounts as $loanAmount) {
            $termsByAmount[$loanAmount->id] = $loanAmount->loan_amount_terms->pluck('term', 'id');
        }

        return $termsByAmount;
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'loan_amount_id' => 'required|exists:loan_amounts,id',
            'loan_amount_term_id' => 'required|numeric|min:1', // Validar que el plazo sea un número positivo
        ]);

        Loan::create($request->all());

        return redirect()->route('loans.index');
    }

    public function show($id)
    {
        $loan = Loan::with('client', 'loanAmount', 'loan_amount_term')->findOrFail($id);
        $amortizationSchedule = $this->generateAmortizationSchedule($loan);
        return view('loans.show', compact('loan', 'amortizationSchedule'));
    }

    private function generateAmortizationSchedule($loan)
      {
         $schedule = [];
         $remainingAmount = $loan->loanAmount->amount;
         $term = $loan->loan_amount_term->term->term;
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
