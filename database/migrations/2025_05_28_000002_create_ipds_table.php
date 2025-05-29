<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ipds', function (Blueprint $table) {
            $table->id();
            $table->string('ipd_no')->nullable();
            $table->string('uhid_no')->nullable();
            $table->string('patient_name')->nullable();
            $table->string('attendant_name')->nullable();
            $table->string('attendant_mobile')->nullable();
            $table->string('second_attendant_name')->nullable();
            $table->string('second_attendant_mobile')->nullable();
            $table->dateTime('admission_date')->nullable();
            $table->dateTime('discharge_date')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('disease')->nullable();
            $table->string('department')->nullable();
            $table->string('ward_name')->nullable();
            $table->string('room_no')->nullable();
            $table->string('bed_no')->nullable();
            $table->string('employee')->nullable();
            $table->string('bill_no')->nullable();
            $table->string('insurance')->nullable();
            $table->string('insurance_name')->nullable();
            $table->string('policy_id')->nullable();
            $table->string('policy_holder_name')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('ipds');
    }
}; 