<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('userid');
            $table->string('password');
            $table->string('passcode');
            $table->string('name');
            $table->string('contact_no');
            $table->string('pan_no');
            $table->string('address');
            $table->string('email')->nullable();
            $table->string('tag_line')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('account_no')->nullable();
            $table->string('gstin_no')->nullable();
            $table->string('cin_no')->nullable();
            $table->string('prefix')->nullable();
            $table->string('signature')->nullable();
            $table->string('stamp')->nullable();
            $table->string('payment_qr')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hospitals');
    }
};
