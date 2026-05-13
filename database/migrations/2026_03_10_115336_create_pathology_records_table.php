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
        if (!Schema::hasTable('pathology_records')) {
            Schema::create('pathology_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pathology_test_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('set null');
            $table->date('test_date');
            $table->text('result')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pathology_records');
    }
};
