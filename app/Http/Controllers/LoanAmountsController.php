<?php

namespace App\Http\Controllers;

use App\Models\LoanAmount;
use App\Models\Term;
use App\Models\LoanAmountTerm;
use Illuminate\Http\Request;

class LoanAmountsController extends Controller
{
    public function index()
    {
        $montosPrestamo = LoanAmount::orderBy('amount', 'desc')->get();

        return view('loan_amounts.index', compact('montosPrestamo'));
    }

    public function create()
    {
        // Método para mostrar el formulario de creación de monto de préstamo
        // obtener plazos de prestamo
        $terms = Term::all();
        return view('loan_amounts.create', compact('terms'));
    }

    /**
     * Almacena un nuevo monto de préstamo y sus términos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0|unique:loan_amounts,amount,' . $request->amount,
            'term_ids' => 'required|array', // Validar que term_ids sea un array
            'term_ids.*' => 'exists:terms,id', // Validar que todos los term_ids existan en la tabla loan_amount_terms
        ]);

        // Crear el LoanAmount
        $loanAmount = LoanAmount::create([
            'amount' => $request->amount,
        ]);

        $selectedTerms = $request->input('term_ids');
        
        // Añadir términos al LoanAmount
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
            // amount no repetido
            'amount' => 'required|numeric|min:0',
        ]);

        // Actualizar el monto de préstamo
        $montoPrestamo->update([
            'amount' => $request->amount,
        ]);

        // Obtener los term_ids seleccionados del formulario
        $selectedTermIds = $request->input('term_ids');

        // Actualizar los términos asociados al monto de préstamo
        $montoPrestamo->loan_amount_terms()->delete(); // Eliminar todos los términos existentes

        foreach ($selectedTermIds as $termId) {
            LoanAmountTerm::create([
                'loan_amount_id' => $montoPrestamo->id,
                'term_id' => $termId,
            ]);
        }

        return redirect()->route('loan_amounts.index')
                         ->with('success', 'Monto de préstamo actualizado correctamente.');
    }

    public function destroy(LoanAmount $montoPrestamo)
    {
        $montoPrestamo->delete();

        return redirect()->route('loan_amounts.index')
                         ->with('success', 'Monto de préstamo eliminado exitosamente.');
    }
}
