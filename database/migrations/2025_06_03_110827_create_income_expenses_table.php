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
        Schema::create('income_expenses', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('type', ['Income', 'Expenses']);
            $table->string('category');
            $table->unsignedBigInteger('item_id');
            $table->decimal('amount', 12, 2);
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('item_id')->references('id')->on('income_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_expenses');
    }
};
