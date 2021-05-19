<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDeliveryNotesTable extends Migration
{
    public function up()
    {
        Schema::create('purchasedeliverynotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->nullable();
            $table->date('date');
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
        });

        Schema::create('purchasedeliverynote_line', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->nullable();
            $table->foreignId('purchasedeliverynote_id');
            $table->foreignId('product_id');
            $table->float('quantity', 16, 3)->default(0);
            $table->float('price_per_unit', 16, 3)->default(0);
            $table->float('total_cost', 16, 3)->default(0);
            $table->timestamps();

            $table->foreign('entity_id')->references('id')->on('entities')->onDelete('cascade');
            $table->foreign('purchasedeliverynote_id')->references('id')->on('purchasedeliverynotes')->onDelete('cascade');
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
        Schema::dropIfExists('purchasedeliverynote_line');
        Schema::dropIfExists('purchasedeliverynotes');
    }
}
