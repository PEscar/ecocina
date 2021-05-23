
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entity_id')->nullable();
            $table->string('name');
            $table->text('detail')->nullable();
            $table->tinyInteger('measure');
            $table->float('stock', 16, 3)->default(0);
            $table->boolean('sales')->default(false);
            $table->boolean('purchases')->default(false);
            $table->boolean('productions')->default(false);
            $table->timestamps();

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
        Schema::dropIfExists('products');
    }
} 