<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->date('payment_date');
            $table->float('salary');
            $table->float('discounts');
            $table->float('contribution_fgts');
            $table->float('fgts_taxrate');
            $table->float('contribution_inss');
            $table->float('inss_taxrate');
            $table->float('contribution_ir');
            $table->float('ir_taxrate');
            $table->json('additionals');
            $table->json('additionals_total');
            $table->json('employee_summary');
            $table->json('employer_summary');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_payments');
    }
};
