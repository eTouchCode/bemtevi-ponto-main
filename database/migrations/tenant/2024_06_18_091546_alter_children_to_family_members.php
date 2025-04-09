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
        Schema::table('employee_children', function (Blueprint $table) {
            $table->dropColumn('school');
        });

        Schema::rename('employee_children', 'employee_family');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::rename('employee_family', 'employee_children');

        Schema::table('employee_children', function (Blueprint $table) {
            $table->string('school')->after('rg');
        });
    }
};
