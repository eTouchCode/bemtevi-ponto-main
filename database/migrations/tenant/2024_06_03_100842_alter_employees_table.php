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
        Schema::table('employees', function (Blueprint $table) {
            $table->string('number')->after('address');
            $table->string('complement')->after('number')->nullable();
            $table->string('neighborhood')->after('complement');
            $table->string('cep')->after('neighborhood');
            $table->integer('status')->default(1)->after('spouse');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('employees', ['number', 'complement', 'neighborhood', 'cep', 'status']);
    }
};
