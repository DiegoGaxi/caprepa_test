<?php

namespace App\Http\Controllers;

use App\Models\LoanAmount;
use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{

    public function create()
    {
        return view('terms.create');
    }

    public function index()
    {
        $terms = Term::all();

        return view('terms.index', compact('terms'));
    }

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

    public function destroy($termId)
    {
        $term = Term::findOrFail($termId);
        $term->delete();

        return redirect()->route('terms.index')
                         ->with('success', 'Término eliminado correctamente.');
    }
}
