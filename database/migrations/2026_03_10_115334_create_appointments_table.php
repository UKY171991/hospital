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
        if (!Schema::hasTable('appointments')) {
            Schema::create('appointments', function (Blueprint $table) {
                $table->id();
                $table->foreignId('patient_id')->constrained()->cascadeOnDelete();
                $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
                $table->dateTime('appointment_date');
                $table->text('reason')->nullable();
                $table->string('status')->default('pending');
                $table->timestamps();
            });
        } else {
            Schema::table('appointments', function (Blueprint $table) {
                if (!Schema::hasColumn('appointments', 'patient_id')) {
                    $table->foreignId('patient_id')->after('id')->constrained()->cascadeOnDelete();
                }
                if (!Schema::hasColumn('appointments', 'doctor_id')) {
                    $table->foreignId('doctor_id')->after('patient_id')->constrained()->cascadeOnDelete();
                }
                if (!Schema::hasColumn('appointments', 'appointment_date')) {
                    $table->dateTime('appointment_date')->after('doctor_id');
                }
                if (!Schema::hasColumn('appointments', 'reason')) {
                    $table->text('reason')->nullable()->after('appointment_date');
                }
                if (!Schema::hasColumn('appointments', 'status')) {
                    $table->string('status')->default('pending')->after('reason');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
