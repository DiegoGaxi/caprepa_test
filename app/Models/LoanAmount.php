<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanAmount extends Model
{
    use HasFactory;

    protected $fillable = ['amount', 'term'];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
