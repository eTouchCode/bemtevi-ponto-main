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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('contract_start');
            $table->string('pis');
            $table->string('cpf');
            $table->string('rg')->nullable();
            $table->date('rg_emission')->nullable();
            $table->string('drivers_license')->nullable();
            $table->string('drivers_license_expiry')->nullable();
            $table->enum('drivers_license_type', ['A', 'B', 'C', 'D', 'E'])->nullable();
            $table->string('address');
            $table->string('email');
            $table->string('phone');
            $table->string('spouse')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
