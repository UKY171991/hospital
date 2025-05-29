<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('name');
            $table->string('patient_id')->nullable();
            $table->string('relation_name')->nullable();
            $table->string('relation_of_relative')->nullable();
            $table->string('relative_title')->nullable();
            $table->string('mobile')->nullable();
            $table->date('reg_date')->nullable();
            $table->string('address')->nullable();
            $table->string('status')->default('Active');
            $table->string('gender')->nullable();
            $table->string('card_no')->nullable();
            $table->string('reference_doctor')->nullable();
            $table->string('aadhar_no')->nullable();
            $table->integer('age')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('color_vision')->nullable();
            $table->integer('height_cm')->nullable();
            $table->integer('weight_kg')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
}; 