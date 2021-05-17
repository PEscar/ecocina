<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->float('quantity', 16, 3)->default(0);
            $table->foreignId('product_id');
            $table->text('detail')->nullable();
            $table->float('total_cost', 16, 3)->default(0);
            $table->float('extra_cost', 16, 3)->default(0);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
        });

        Schema::create('recipe_line', function (Blueprint $table) {
            $table->id();
            $table->foreignId('recipe_id');
            $table->foreignId('product_id');
            $table->float('quantity', 16, 3)->default(0);
            $table->text('detail')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
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
        Schema::dropIfExists('recipes');
        Schema::dropIfExists('recipe_line');
    }
}
