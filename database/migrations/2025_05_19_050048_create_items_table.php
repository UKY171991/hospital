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
        Schema::create('items', function (Blueprint $table) {
            $table->id(); // S.No can be derived from this or be a separate auto-incrementing display counter in the view
            $table->string('item_name');
            $table->string('item_code')->unique()->nullable(); // Assuming item code can be optional but unique if present
            $table->decimal('purchase_price', 10, 2)->default(0.00);
            $table->decimal('sales_price', 10, 2)->default(0.00);
            $table->string('unit')->nullable();
            $table->integer('opening_stock')->default(0);
            $table->integer('current_stock')->default(0);
            // Add any foreign keys if items are related to other tables, e.g., a hospital_id
            // $table->foreignId('hospital_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
