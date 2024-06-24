<?php

namespace App\Http\Controllers;

use App\Models\LoanAmount;
use App\Models\Term;
use App\Models\LoanAmountTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoanAmountsController extends Controller
{
    public function index()
    {
        $montosPrestamo = LoanAmount::orderBy('amount', 'desc')->get();

        return view('loan_amounts.index', compact('montosPrestamo'));
    }

    public function create()
    {
        // obtener plazos de prestamo
        $terms = Term::all();
        return view('loan_amounts.create', compact('terms'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0|unique:loan_amounts,amount,' . $request->amount,
            'term_ids' => 'required|array', // Validar que term_ids sea un array
            'term_ids.*' => 'exists:terms,id', // Validar que todos los term_ids existan en la tabla terms
        ]);

        // Crear el LoanAmount
        $loanAmount = LoanAmount::create([
            'amount' => $request->amount,
        ]);

        $selectedTerms = $request->input('term_ids');
        
        // Añadir plazos al LoanAmount
        foreach ($selectedTerms as $termId) {
            LoanAmountTerm::create([
                'loan_amount_id' => $loanAmount->id,
                'term_id' => $termId,
            ]);
        }

        return redirect()->route('loan_amounts.index')
                         ->with('success', 'Monto de préstamo creado correctamente.');
    }
    
    public function show(LoanAmount $montoPrestamo)
    {
        return view('loan_amounts.show', compact('montoPrestamo'));
    }

    public function edit(LoanAmount $montoPrestamo)
    {
        $terms = Term::all();
        return view('loan_amounts.edit', compact('montoPrestamo', 'terms'));
    }

    public function update(Request $request, LoanAmount $montoPrestamo)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'term_ids' => 'array',
        ]);

        try {
            $montoPrestamo->update([
                'amount' => $request->amount,
            ]);

            $selectedTermIds = $request->input('term_ids', []);

            // Obtener los term_ids actuales asociados al monto de préstamo
            $currentTermIds = $montoPrestamo->loan_amount_terms()->pluck('term_id')->toArray();

            // Verificar los term_ids existentes para este monto de préstamo específico
            $existingTermIds = LoanAmountTerm::where('loan_amount_id', $montoPrestamo->id)
            ->whereIn('term_id', $selectedTermIds)
            ->pluck('term_id')
            ->toArray();
            
            // Calcular los term_ids que se van a agregar (los que no existen)
            $termsToAttach = array_diff($selectedTermIds, $currentTermIds);

            // Calcular los term_ids que se van a eliminar (los que ya no están seleccionados)
            $termsToDetach = array_diff($currentTermIds, $selectedTermIds);

            // Agregar los nuevos term_ids
            foreach ($termsToAttach as $termId) {
                // Verificar si el term_id ya existe en la base de datos antes de crear
                if (!in_array($termId, $existingTermIds)) {
                    LoanAmountTerm::create([
                        'loan_amount_id' => $montoPrestamo->id,
                        'term_id' => $termId,
                    ]);
                }
            }

            // Eliminar los term_ids que ya no están seleccionados
            if (!empty($termsToDetach)) {
                $montoPrestamo->loan_amount_terms()->whereIn('term_id', $termsToDetach)->delete();
            }

            return redirect()->route('loan_amounts.index')
                            ->with('success', 'Monto de préstamo actualizado correctamente.');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    
    public function destroy(LoanAmount $montoPrestamo)
    {
        $montoPrestamo->delete();
        return redirect()->route('loan_amounts.index')
                         ->with('success', 'Monto de préstamo eliminado exitosamente.');
    }
}
