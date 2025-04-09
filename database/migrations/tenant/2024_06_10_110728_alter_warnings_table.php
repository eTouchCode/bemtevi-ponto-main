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
        Schema::table('warnings', function (Blueprint $table) {
            // $table->dropColumn('plannedDate');
            $table->string('icon')->after('warningType');
            $table->enum('target', ['company', 'admins', 'employee'])->after('icon');
            $table->string('title')->after('target');
            $table->string('message')->after('title');
            $table->date('end_date')->nullable()->after('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropColumns('warnings', ['icon', 'target', 'title', 'message']);
    }
};
