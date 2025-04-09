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
        Schema::table('tax_rates', function (Blueprint $table) {
            $table->boolean('reduction')->default(0)->after('percentage');
            $table->float('reduction_value')->nullable()->after('reduction');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('tax_rates', ['reduction', 'reduction_value']);
    }
};
