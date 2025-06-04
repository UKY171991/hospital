<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncomeItemsTable extends Migration
{
    public function up()
    {
        Schema::create('income_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->string('type');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->string('unit');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('income_categories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('income_items');
    }
}
