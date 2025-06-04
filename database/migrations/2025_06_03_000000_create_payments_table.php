<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('select_type');
            $table->string('doctor_name')->nullable();
            $table->date('date');
            $table->string('payment_ref_no')->nullable();
            $table->decimal('before_due_amount', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('after_due_amount', 12, 2)->default(0);
            $table->string('transaction_ref_no')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('payer_bank')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->text('narration')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}; 