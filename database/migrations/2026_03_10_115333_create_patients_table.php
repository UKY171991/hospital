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
        if (!Schema::hasTable('patients')) {
            Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->date('dob');
            $table->string('gender');
            $table->text('address')->nullable();
            $table->string('blood_group')->nullable();
            $table->timestamps();
        });
        } else {
            Schema::table('patients', function (Blueprint $table) {
                if (!Schema::hasColumn('patients', 'name')) {
                    $table->string('name')->after('id');
                }
                if (!Schema::hasColumn('patients', 'email')) {
                    $table->string('email')->nullable()->after('name');
                }
                if (!Schema::hasColumn('patients', 'phone')) {
                    $table->string('phone')->after('email');
                }
                if (!Schema::hasColumn('patients', 'dob')) {
                    $table->date('dob')->after('phone');
                }
                if (!Schema::hasColumn('patients', 'gender')) {
                    $table->string('gender')->after('dob');
                }
                if (!Schema::hasColumn('patients', 'address')) {
                    $table->text('address')->nullable()->after('gender');
                }
                if (!Schema::hasColumn('patients', 'blood_group')) {
                    $table->string('blood_group')->nullable()->after('address');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
