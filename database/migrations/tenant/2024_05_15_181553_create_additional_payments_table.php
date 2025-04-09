<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('additional_payments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->float('amount');
            $table->boolean('percentageValue')->default(false);
            $table->boolean('fgts')->default(false);
            $table->boolean('inss')->default(false);
            $table->boolean('ir')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_payments');
    }
};
