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
        if (! Schema::hasTable('pathology_records')) {
            return;
        }

        Schema::table('pathology_records', function (Blueprint $table) {
            if (! Schema::hasColumn('pathology_records', 'main_test_category_id')) {
                $table->unsignedBigInteger('main_test_category_id')->nullable()->after('section')->index();
            }

            if (! Schema::hasColumn('pathology_records', 'test_category_id')) {
                $table->unsignedBigInteger('test_category_id')->nullable()->after('main_test_category_id')->index();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('pathology_records')) {
            return;
        }

        Schema::table('pathology_records', function (Blueprint $table) {
            if (Schema::hasColumn('pathology_records', 'main_test_category_id')) {
                $table->dropIndex(['main_test_category_id']);
            }

            if (Schema::hasColumn('pathology_records', 'test_category_id')) {
                $table->dropIndex(['test_category_id']);
            }

            $columnsToDrop = array_values(array_filter([
                Schema::hasColumn('pathology_records', 'main_test_category_id') ? 'main_test_category_id' : null,
                Schema::hasColumn('pathology_records', 'test_category_id') ? 'test_category_id' : null,
            ]));

            if ($columnsToDrop !== []) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
