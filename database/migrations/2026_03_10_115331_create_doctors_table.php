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
        if (!Schema::hasTable('doctors')) {
            Schema::create('doctors', function (Blueprint $table) {
                $table->id();
                $table->foreignId('department_id')->constrained()->cascadeOnDelete();
                $table->string('name');
                $table->string('email')->unique();
                $table->string('phone');
                $table->decimal('consultation_fee', 10, 2);
                $table->string('status')->default('active');
                $table->timestamps();
            });
        } else {
            Schema::table('doctors', function (Blueprint $table) {
                if (!Schema::hasColumn('doctors', 'department_id')) {
                    $table->foreignId('department_id')->after('id')->constrained()->cascadeOnDelete();
                }
                if (!Schema::hasColumn('doctors', 'name')) {
                    $table->string('name')->after('department_id');
                }
                if (!Schema::hasColumn('doctors', 'email')) {
                    $table->string('email')->unique()->after('name');
                }
                if (!Schema::hasColumn('doctors', 'phone')) {
                    $table->string('phone')->after('email');
                }
                if (!Schema::hasColumn('doctors', 'consultation_fee')) {
                    $table->decimal('consultation_fee', 10, 2)->after('phone');
                }
                if (!Schema::hasColumn('doctors', 'status')) {
                    $table->string('status')->default('active')->after('consultation_fee');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
