<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeAndIncomeTypeToIncomeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('income_categories', function (Blueprint $table) {
            $table->string('type')->nullable();
            $table->string('income_type')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('income_categories', function (Blueprint $table) {
            $table->dropColumn(['type', 'income_type']);
        });
    }
}
