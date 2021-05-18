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
            $table->foreignId('entity_id');
            $table->string('name');
            $table->foreignId('product_id');
            $table->float('quantity', 16, 3)->default(0);
            $table->text('detail')->nullable();
            $table->float('extra_cost', 16, 3)->default(0);
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
        });

        Schema::create('recipe_line', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id');
            $table->foreignId('recipe_id');
            $table->foreignId('product_id');
            $table->float('quantity', 16, 3)->default(0);
            $table->text('detail')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_line');
        Schema::dropIfExists('recipes');
    }
}
