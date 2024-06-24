<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanAmountTermsTable extends Migration
{
    public function up()
    {
        Schema::create('loan_amount_terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_amount_id')->constrained('loan_amounts')->onDelete('cascade');
            $table->foreignId('term_id')->constrained('terms')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('loan_amount_terms');
    }
}
