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
        // Departments
        if (Schema::hasTable('departments')) {
            Schema::table('departments', function (Blueprint $table) {
                if (!Schema::hasColumn('departments', 'name')) $table->string('name')->after('id');
                if (!Schema::hasColumn('departments', 'description')) $table->text('description')->nullable()->after('name');
                if (!Schema::hasColumn('departments', 'status')) $table->string('status')->default('active')->after('description');
            });
        }

        // Doctors
        if (Schema::hasTable('doctors')) {
            Schema::table('doctors', function (Blueprint $table) {
                if (!Schema::hasColumn('doctors', 'department_id')) $table->foreignId('department_id')->nullable()->constrained()->cascadeOnDelete()->after('id');
                if (!Schema::hasColumn('doctors', 'name')) $table->string('name')->after('department_id');
                if (!Schema::hasColumn('doctors', 'email')) $table->string('email')->nullable()->after('name');
                if (!Schema::hasColumn('doctors', 'phone')) $table->string('phone')->nullable()->after('email');
                if (!Schema::hasColumn('doctors', 'consultation_fee')) $table->decimal('consultation_fee', 10, 2)->default(0)->after('phone');
                if (!Schema::hasColumn('doctors', 'status')) $table->string('status')->default('active')->after('consultation_fee');
            });
        }

        // Patients
        if (Schema::hasTable('patients')) {
            Schema::table('patients', function (Blueprint $table) {
                if (!Schema::hasColumn('patients', 'name')) $table->string('name')->after('id');
                if (!Schema::hasColumn('patients', 'email')) $table->string('email')->nullable()->after('name');
                if (!Schema::hasColumn('patients', 'phone')) $table->string('phone')->nullable()->after('email');
                if (!Schema::hasColumn('patients', 'dob')) $table->date('dob')->nullable()->after('phone');
                if (!Schema::hasColumn('patients', 'gender')) $table->string('gender')->nullable()->after('dob');
                if (!Schema::hasColumn('patients', 'address')) $table->text('address')->nullable()->after('gender');
                if (!Schema::hasColumn('patients', 'blood_group')) $table->string('blood_group')->nullable()->after('address');
            });
        }

        // Appointments
        if (Schema::hasTable('appointments')) {
            Schema::table('appointments', function (Blueprint $table) {
                if (!Schema::hasColumn('appointments', 'patient_id')) $table->foreignId('patient_id')->nullable()->constrained()->cascadeOnDelete()->after('id');
                if (!Schema::hasColumn('appointments', 'doctor_id')) $table->foreignId('doctor_id')->nullable()->constrained()->cascadeOnDelete()->after('patient_id');
                if (!Schema::hasColumn('appointments', 'appointment_date')) $table->dateTime('appointment_date')->nullable()->after('doctor_id');
                if (!Schema::hasColumn('appointments', 'status')) $table->string('status')->default('pending')->after('appointment_date');
            });
        }

        // Medicines
        if (Schema::hasTable('medicines')) {
            Schema::table('medicines', function (Blueprint $table) {
                if (!Schema::hasColumn('medicines', 'name')) $table->string('name')->after('id');
                if (!Schema::hasColumn('medicines', 'price')) $table->decimal('price', 10, 2)->default(0)->after('name');
                if (!Schema::hasColumn('medicines', 'stock_quantity')) $table->integer('stock_quantity')->default(0)->after('price');
            });
        }

        // Medicine Sales
        if (Schema::hasTable('medicine_sales')) {
            Schema::table('medicine_sales', function (Blueprint $table) {
                if (!Schema::hasColumn('medicine_sales', 'patient_id')) $table->foreignId('patient_id')->nullable()->constrained()->onDelete('set null')->after('id');
                if (!Schema::hasColumn('medicine_sales', 'medicine_id')) $table->foreignId('medicine_id')->nullable()->constrained()->cascadeOnDelete()->after('patient_id');
                if (!Schema::hasColumn('medicine_sales', 'quantity')) $table->integer('quantity')->default(1)->after('medicine_id');
                if (!Schema::hasColumn('medicine_sales', 'total_amount')) $table->decimal('total_amount', 10, 2)->default(0)->after('quantity');
                if (!Schema::hasColumn('medicine_sales', 'sale_date')) $table->date('sale_date')->nullable()->after('total_amount');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No rollback for schema repairs to avoid data loss.
    }
};
