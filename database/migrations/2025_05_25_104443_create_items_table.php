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
            $table->id();
            $table->string('type'); // Service/Product
            $table->string('item_name');
            $table->string('item_code')->nullable();
            $table->string('hsn_sac_code')->nullable();
            $table->decimal('sales_price', 10, 2);
            $table->decimal('purchase_price', 10, 2);
            $table->string('unit')->nullable();
            $table->integer('opening_stock')->default(0);
            $table->integer('current_stock')->default(0);
            $table->string('status')->default('Active');
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
