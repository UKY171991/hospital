<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->default('user');
            });
        }
        $tables = ['doctors', 'appointments', 'pathology_records', 'medicine_sales', 'patients', 'departments'];
        foreach ($tables as $table) {
            if (!Schema::hasColumn($table, 'user_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
                });
            }
        }
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
        $tables = ['doctors', 'appointments', 'pathology_records', 'medicine_sales', 'patients', 'departments'];
        foreach ($tables as $name) {
             Schema::table($name, function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            });
        }
    }
};
