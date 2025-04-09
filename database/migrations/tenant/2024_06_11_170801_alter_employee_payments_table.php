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
        Schema::table('employee_payments', function (Blueprint $table) {
            $table->float('fgts_base')->after('fgts_taxrate');
            $table->float('inss_base')->after('inss_taxrate');
            $table->float('ir_base')->after('ir_taxrate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('employee_payments', ['fgts_base', 'inss_base', 'ir_base']);
    }
};
