<?php

$migrationsDir = __DIR__ . '/database/migrations';
$modelsDir = __DIR__ . '/app/Models';

$schemas = [
    'departments' => "\$table->string('name');\n            \$table->text('description')->nullable();\n            \$table->string('status')->default('active');",
    'doctors' => "\$table->foreignId('department_id')->constrained()->cascadeOnDelete();\n            \$table->string('name');\n            \$table->string('email')->unique();\n            \$table->string('phone');\n            \$table->decimal('consultation_fee', 10, 2);\n            \$table->string('status')->default('active');",
    'patients' => "\$table->string('name');\n            \$table->string('email')->nullable();\n            \$table->string('phone');\n            \$table->date('dob');\n            \$table->string('gender');\n            \$table->text('address')->nullable();\n            \$table->string('blood_group')->nullable();",
    'appointments' => "\$table->foreignId('patient_id')->constrained()->cascadeOnDelete();\n            \$table->foreignId('doctor_id')->constrained()->cascadeOnDelete();\n            \$table->dateTime('appointment_date');\n            \$table->text('reason')->nullable();\n            \$table->string('status')->default('pending');",
    'pathology_tests' => "\$table->string('test_name');\n            \$table->string('category');\n            \$table->text('normal_range')->nullable();\n            \$table->decimal('price', 10, 2);",
    'pathology_records' => "\$table->foreignId('patient_id')->constrained()->cascadeOnDelete();\n            \$table->foreignId('pathology_test_id')->constrained()->cascadeOnDelete();\n            \$table->foreignId('doctor_id')->nullable()->constrained()->onDelete('set null');\n            \$table->date('test_date');\n            \$table->text('result')->nullable();\n            \$table->string('status')->default('pending');",
    'medicines' => "\$table->string('name');\n            \$table->string('category');\n            \$table->string('manufacturer');\n            \$table->decimal('price', 10, 2);\n            \$table->integer('stock_quantity');\n            \$table->date('expiry_date');",
    'medicine_sales' => "\$table->foreignId('patient_id')->nullable()->constrained()->onDelete('set null');\n            \$table->foreignId('medicine_id')->constrained()->cascadeOnDelete();\n            \$table->integer('quantity');\n            \$table->decimal('total_amount', 10, 2);\n            \$table->date('sale_date');",
];

$files = glob($migrationsDir . '/*create*.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    foreach ($schemas as $table => $schema) {
        if (strpos($file, 'create_' . $table . '_table') !== false) {
            $content = preg_replace('/Schema::create\(\'' . $table . '\', function \(Blueprint \$table\) \{(.*?)\}\);/s', "Schema::create('" . $table . "', function (Blueprint \$table) {\n            \$table->id();\n            $schema\n            \$table->timestamps();\n        });", $content);
            file_put_contents($file, $content);
            echo "Updated migration for $table\n";
        }
    }
}

// Update Models to have $guarded = []
$models = ['Department', 'Doctor', 'Patient', 'Appointment', 'PathologyTest', 'PathologyRecord', 'Medicine', 'MedicineSale'];
foreach ($models as $model) {
    $modelFile = $modelsDir . '/' . $model . '.php';
    if (file_exists($modelFile)) {
        $content = file_get_contents($modelFile);
        $content = str_replace("use HasFactory;", "use HasFactory;\n    protected \$guarded = [];", $content);
        file_put_contents($modelFile, $content);
        echo "Updated model $model\n";
    }
}

echo "Done\n";
