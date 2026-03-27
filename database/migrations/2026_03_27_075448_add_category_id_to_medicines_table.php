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
        Schema::table('medicines', function (Blueprint $table) {
            if (!Schema::hasColumn('medicines', 'medicine_category_id')) {
                $table->foreignId('medicine_category_id')->nullable()->after('name')->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('medicines', 'medicine_manufacturer_id')) {
                $table->foreignId('medicine_manufacturer_id')->nullable()->after('medicine_category_id')->constrained()->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropForeign(['medicine_category_id']);
            $table->dropForeign(['medicine_manufacturer_id']);
            $table->dropColumn(['medicine_category_id', 'medicine_manufacturer_id']);
        });
    }
};
