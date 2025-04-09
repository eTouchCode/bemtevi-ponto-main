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
        // Schema::table('salaries', function (Blueprint $table) {
        //     $table->renameColumn('permanent_change', 'temporary_change');
        // });
        DB::statement("ALTER TABLE salaries CHANGE COLUMN permanent_change temporary_change VARCHAR(255);");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salaries', function (Blueprint $table) {
            $table->renameColumn('temporary_change', 'permanent_change');
        });
    }
};
