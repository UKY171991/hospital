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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('client_name');
            $table->string('mobile_no');
            $table->text('address')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('total_discount', 10, 2)->default(0.00);
            $table->decimal('grand_total', 10, 2);
            $table->text('remark')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Assuming sales are created by a logged-in user
            $table->foreignId('hospital_id')->nullable()->constrained()->onDelete('set null'); // Assuming sales can be linked to a hospital, nullable if not always required or if hospital can be deleted
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
