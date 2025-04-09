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
        Schema::create('employee_attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->date('date');
            $table->time('firstEntranceTime')->nullable();
            $table->time('firstExitTime')->nullable();
            $table->time('breakDuration')->nullable();
            $table->time('secondEntranceTime')->nullable();
            $table->time('secondExitTime')->nullable();
            $table->time('shiftDuration')->nullable();
            $table->time('shiftExtraTime')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_attendances');
    }
};
