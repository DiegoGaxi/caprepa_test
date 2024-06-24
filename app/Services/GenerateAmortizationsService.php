<?php

namespace App\Services;

use App\Models\Loan;
use Carbon\Carbon;

class GenerateAmortizationsService
{
    public function generateAmortizationSchedule(Loan $loan)
    {
        $schedule = [];
        $remainingAmount = $loan->loanAmount->amount;
        $term = $loan->loan_amount_term->term->term;
        $interestRate = 11; // Tasa de interés mensual

        $paymentAmount = $remainingAmount / $term;

        $totalPayment = 0;
        $totalInterest = 0;
        $totalPrincipal = 0;

        $currentDate = now();

        for ($i = 1; $i <= $term; $i++) {
            $principal = $paymentAmount + $interestRate;

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

            $totalPayment += $paymentAmount;
            $totalInterest += $interestRate;
            $totalPrincipal += $principal;

            $currentDate = $paymentDate->copy()->addDay();
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
