<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('day_books', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_particular');
            $table->decimal('credit', 12, 2)->default(0);
            $table->decimal('debit', 12, 2)->default(0);
            $table->decimal('balance', 12, 2)->default(0);
            $table->string('report_type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('day_books');
    }
}; 