<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanAmount extends Model
{
    use HasFactory;

    protected $fillable = ['amount'];

    public function loan_amount_terms()
    {
        return $this->hasMany(LoanAmountTerm::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
