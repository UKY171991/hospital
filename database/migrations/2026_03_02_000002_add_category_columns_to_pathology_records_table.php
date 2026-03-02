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
        Schema::table('pathology_records', function (Blueprint $table) {
            $table->unsignedBigInteger('main_test_category_id')->nullable()->after('section')->index();
            $table->unsignedBigInteger('test_category_id')->nullable()->after('main_test_category_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pathology_records', function (Blueprint $table) {
            $table->dropIndex(['main_test_category_id']);
            $table->dropIndex(['test_category_id']);
            $table->dropColumn(['main_test_category_id', 'test_category_id']);
        });
    }
};
