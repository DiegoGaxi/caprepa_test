<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanAmountTerm extends Model
{
    use HasFactory;

    protected $fillable = ['loan_amount_id', 'term_id'];

    public function loanAmount()
    {
        return $this->belongsTo(LoanAmount::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function term()
    {
        return $this->belongsTo(Term::class);
    }
}
