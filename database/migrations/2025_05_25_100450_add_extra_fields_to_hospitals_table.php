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
        Schema::table('hospitals', function (Blueprint $table) {
            $table->string('email')->nullable();
            $table->string('hospital_tag_line')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('account_no')->nullable();
            $table->string('gstin_no')->nullable();
            $table->string('cin_no')->nullable();
            $table->string('hospital_prefix')->nullable();
            $table->string('signature')->nullable();
            $table->string('stamp')->nullable();
            $table->string('payment_qr')->nullable();
            $table->string('letter_head')->nullable();
            $table->string('idcard_design')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospitals', function (Blueprint $table) {
            $table->dropColumn([
                'email',
                'hospital_tag_line',
                'bank_name',
                'branch_name',
                'ifsc_code',
                'account_no',
                'gstin_no',
                'cin_no',
                'hospital_prefix',
                'signature',
                'stamp',
                'payment_qr',
                'letter_head',
                'idcard_design',
            ]);
        });
    }
};
