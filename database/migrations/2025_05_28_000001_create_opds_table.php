<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('opds', function (Blueprint $table) {
            $table->id();
            $table->string('opd_type')->nullable();
            $table->string('opd_no')->nullable();
            $table->date('admission_date')->nullable();
            $table->string('patient_id')->nullable();
            $table->string('name')->nullable();
            $table->string('address')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('disease')->nullable();
            $table->decimal('doctor_fee', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->decimal('due_amount', 10, 2)->nullable();
            $table->string('prepared_by')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('reference_doctor')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('opds');
    }
}; 