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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['Employee Wise', 'Doctor Wise']);
            $table->date('date');
            $table->string('name');
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('duty_type')->nullable();
            $table->string('duty_chart_no')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
