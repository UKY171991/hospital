<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('passcode')->nullable()->after('password');
            $table->string('mobile_no')->nullable()->after('name');
            $table->string('status')->default('Active')->after('email_verified_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['passcode', 'mobile_no', 'status']);
        });
    }
}; 