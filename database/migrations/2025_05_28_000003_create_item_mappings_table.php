<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_mappings', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->date('date')->nullable();
            $table->string('patient_name')->nullable();
            $table->string('patient_contact_no')->nullable();
            $table->string('item_name')->nullable();
            $table->string('item_code')->nullable();
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('item_mappings');
    }
}; 