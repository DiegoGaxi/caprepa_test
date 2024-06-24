<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'loan_amount_id', 'loan_amount_term_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function loanAmount()
    {
        return $this->belongsTo(LoanAmount::class);
    }

    public function loan_amount_term()
    {
        return $this->belongsTo(LoanAmountTerm::class);
    }

    public static function filter(Request $request)
    {
        $query = static::query();

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

        return $query->with('client', 'loanAmount', 'loan_amount_term.term');
    }
}
