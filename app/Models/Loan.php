<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'loan_amount_id'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function loanAmount()
    {
        return $this->belongsTo(LoanAmount::class);
    }
}
