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
        Schema::table('doctors', function (Blueprint $table) {
            if (!Schema::hasColumn('doctors', 'qualification')) {
                $table->string('qualification')->nullable();
            }
            if (!Schema::hasColumn('doctors', 'specialization')) {
                $table->string('specialization')->nullable();
            }
            if (!Schema::hasColumn('doctors', 'opd_timing')) {
                $table->string('opd_timing')->nullable();
            }
        });

        Schema::create('opd_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->text('symptoms')->nullable();
            $table->date('visit_date');
            $table->string('token_no')->nullable();
            $table->string('status')->default('waiting'); // waiting, consultation, completed
            $table->timestamps();
        });

        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('opd_visit_id')->constrained('opd_visits')->cascadeOnDelete();
            $table->string('medicine_name');
            $table->string('dosage')->nullable();
            $table->string('duration')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
            $table->foreignId('opd_visit_id')->nullable()->constrained('opd_visits')->nullOnDelete();
            $table->decimal('total_amount', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->string('payment_status')->default('unpaid'); // unpaid, paid, partially_paid
            $table->string('payment_mode')->nullable(); // cash, card, online
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('opd_visits');
        
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['qualification', 'specialization', 'opd_timing']);
        });
    }
};
