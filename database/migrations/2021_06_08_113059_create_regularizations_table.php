<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegularizationsTable extends Migration
{
    public function up()
    {
        Schema::create('regularizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->nullable();
            $table->string('detail')->nullable();
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
        });

        Schema::create('regularization_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->nullable();
            $table->foreignId('header_id');
            $table->foreignId('product_id');
            $table->enum('stock_movement_type', ['in', 'out']);
            $table->boolean('update_product_average_cost')->default(false);
            $table->float('quantity', 16, 3)->default(0);
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('header_id')->references('id')->on('regularizations')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regularization_lines');
        Schema::dropIfExists('regularizations');
    }
}
