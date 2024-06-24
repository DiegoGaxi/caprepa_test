<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Loan;
use App\Models\LoanAmount;
use App\Services\GenerateAmortizationsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanController extends Controller
{
    protected $generateAmortizationsService;

    public function __construct(GenerateAmortizationsService $generateAmortizationsService)
    {
        $this->generateAmortizationsService = $generateAmortizationsService;
    }
    
    public function index(Request $request)
    {
        $query = Loan::filter($request);
        $loans = $query->get();
        return view('loans.index', compact('loans'));
    }

    public function create()
    {
        $clients = Client::all();
        $loanAmounts = LoanAmount::with('loan_amount_terms')->get(); // Obtener todos los montos de préstamo con sus plazos
        $termsByAmount = $this->getTermsByLoanAmounts($loanAmounts); // Obtener plazos por cantidad de préstamo
        return view('loans.create', compact('clients', 'loanAmounts', 'termsByAmount'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|exists:clients,id',
            'loan_amount_id' => 'required|exists:loan_amounts,id',
            'loan_amount_term_id' => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        \DB::beginTransaction();
        try {
            $loan = Loan::create($request->all());
            \DB::commit();
            return redirect()->route('loans.index')->with('success', '¡Préstamo creado exitosamente!');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Ocurrió un error al guardar el préstamo. Inténtalo nuevamente.'])->withInput();
        }
    }

    public function show($id)
    {
        $loan = Loan::with('client', 'loanAmount', 'loan_amount_term')->findOrFail($id);
        $amortizationSchedule = $this->generateAmortizationsService->generateAmortizationSchedule($loan);
        return view('loans.show', compact('loan', 'amortizationSchedule'));
    }

    // -------------------------------------------------------------------------------------------------------------------------------------

    private function getTermsByLoanAmounts($loanAmounts)
    {
        $termsByAmount = [];
        foreach ($loanAmounts as $loanAmount) {
            $termsByAmount[$loanAmount->id] = $loanAmount->loan_amount_terms->pluck('term', 'id');
        }
        return $termsByAmount;
    }
}