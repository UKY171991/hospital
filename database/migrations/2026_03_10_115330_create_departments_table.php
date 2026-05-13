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
        if (!Schema::hasTable('departments')) {
            Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
        } else {
            Schema::table('departments', function (Blueprint $table) {
                if (!Schema::hasColumn('departments', 'name')) {
                    $table->string('name')->after('id');
                }
                if (!Schema::hasColumn('departments', 'description')) {
                    $table->text('description')->nullable()->after('name');
                }
                if (!Schema::hasColumn('departments', 'status')) {
                    $table->string('status')->default('active')->after('description');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
