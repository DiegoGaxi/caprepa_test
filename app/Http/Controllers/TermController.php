<?php

namespace App\Http\Controllers;

use App\Models\LoanAmount;
use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{

    public function create()
    {
        // Método para mostrar el formulario de creación de monto de préstamo
        return view('terms.create');
    }

    /**
     * Muestra el listado de términos de préstamo.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $terms = Term::all();

        return view('terms.index', compact('terms'));
    }

/**
     * Almacena un nuevo término de préstamo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'term' => 'required|integer',
        ]);

        $term = new Term(['term' => $request->term]);
        $term->save();

        return redirect()->route('terms.index')
                         ->with('success', 'Término agregado correctamente.');
    }

    /**
     * Elimina un término de un monto de préstamo específico.
     *
     * @param  int  $termId
     * @return \Illuminate\Http\Response
     */
    public function destroy($termId)
    {
        $term = Term::findOrFail($termId);
        $term->delete();

        return redirect()->route('terms.index')
                         ->with('success', 'Término eliminado correctamente.');
    }
}
