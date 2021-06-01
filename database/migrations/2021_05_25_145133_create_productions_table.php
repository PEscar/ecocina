<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->nullable();
            $table->foreignId('recipe_id');
            $table->float('recipe_quantity', 16, 3)->default(0);
            $table->float('recipe_extra_cost', 16, 3)->default(0);
            $table->float('recipe_lines_cost', 16, 3)->default(0);
            $table->smallInteger('times', false, true)->default(0);
            $table->float('quantity', 16, 3)->default(0);
            $table->float('total', 16, 7)->default(0);
            $table->tinyInteger('status')->default(1)->comment('1: planified | 2: launched | 3: finished');
            $table->dateTime('planified_date')->nullable();
            $table->dateTime('launch_date')->nullable();
            $table->dateTime('finish_date')->nullable();
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('recipe_id')->references('id')->on('recipes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productions');
    }
}
