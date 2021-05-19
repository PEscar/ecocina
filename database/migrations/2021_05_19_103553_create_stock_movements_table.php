<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockMovementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->nullable();
            $table->date('date');
            $table->morphs('parentable');
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
        });

        Schema::create('stock_movement_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->nullable();
            $table->enum('type', ['in', 'out']);
            $table->foreignId('stock_movement_id');
            $table->foreignId('product_id');
            $table->unsignedFloat('quantity', 16, 3)->default(0);
            $table->morphs('parentable');
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('stock_movement_id')->references('id')->on('stock_movements')->onDelete('cascade');
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
        Schema::dropIfExists('stock_movement_lines');
        Schema::dropIfExists('stock_movements');
    }
}
