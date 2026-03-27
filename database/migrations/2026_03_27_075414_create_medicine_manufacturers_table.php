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
        if (!Schema::hasTable('medicine_manufacturers')) {
            Schema::create('medicine_manufacturers', function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique();
                $table->text('address')->nullable();
                $table->string('contact_number')->nullable();
                $table->string('status')->default('active');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicine_manufacturers');
    }
};
