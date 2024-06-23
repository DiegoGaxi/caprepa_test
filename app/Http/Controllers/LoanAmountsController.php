<?php

namespace App\Http\Controllers;

use App\Models\LoanAmount;
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
        return view('loan_amounts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'term' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    // Validar que no exista otro registro con el mismo amount y term
                    $exists = \App\Models\LoanAmount::where('amount', $request->amount)
                        ->where('term', $value)
                        ->exists();
        
                    if ($exists) {
                        $fail("Ya existe un préstamo con el mismo monto y plazo.");
                    }
                },
            ],
        ]);
    
        LoanAmount::create([
            'amount' => $request->amount,
            'term' => $request->term,
        ]);
    
        return redirect()->route('loan_amounts.index')
                         ->with('success', 'Monto de préstamo creado exitosamente.');
    }
    
    public function show(LoanAmount $montoPrestamo)
    {
        return view('loan_amounts.show', compact('montoPrestamo'));
    }

    public function edit(LoanAmount $montoPrestamo)
    {
        return view('loan_amounts.edit', compact('montoPrestamo'));
    }

    public function update(Request $request, LoanAmount $montoPrestamo)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'term' => 'required|integer|min:1', // El plazo debe ser quincenal
            // Agrega más reglas de validación según sea necesario
        ]);

        $montoPrestamo->update($request->all());

        return redirect()->route('loan_amounts.index')
                         ->with('success', 'Monto de préstamo actualizado exitosamente.');
    }

    public function destroy(LoanAmount $montoPrestamo)
    {
        $montoPrestamo->delete();

        return redirect()->route('loan_amounts.index')
                         ->with('success', 'Monto de préstamo eliminado exitosamente.');
    }
}
