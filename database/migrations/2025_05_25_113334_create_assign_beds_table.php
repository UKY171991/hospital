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
        Schema::create('assign_beds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bed_id');
            $table->string('patient_name');
            $table->date('assign_date');
            $table->date('release_date')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();

            $table->foreign('bed_id')->references('id')->on('beds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assign_beds');
    }
};
