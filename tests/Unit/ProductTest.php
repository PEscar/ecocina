<?php

namespace Tests\Unit;

use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions; 

class ProductTest extends TestCase
{
	use DatabaseTransactions;

	// IN

    public function testStockIn()
    {
    	$product = factory(Product::class)->make();
    	$old_stock = $product->stock;
    	$increased_stock = 85;

    	$product->updateStock($increased_stock);

    	$this->assertEquals($old_stock + $increased_stock, $product->stock);
    }

    public function testStockInAverageCostCorrectlyUpdated()
    {
    	$product = factory(Product::class)->make(['stock' => 2, 'average_cost' => 4]);
    	$old_stock = $product->stock;
    	$old_average = $product->average_cost;

    	$increased_stock = 4;
    	$increased_total_cost = $increased_stock * 2;

    	$product->updateStock($increased_stock, $increased_total_cost, true, true);

    	$this->assertEquals(16/6, $product->average_cost);
    }

    public function testStockInAverageCostCorrectlyNotUpdated()
    {
    	$product = factory(Product::class)->make(['stock' => 2, 'average_cost' => 4]);
    	$old_stock = $product->stock;
    	$old_average = $product->average_cost;

    	$increased_stock = 4;
    	$increased_total_cost = $increased_stock * 2;

    	$product->updateStock($increased_stock, $increased_total_cost, true, false);

    	$this->assertEquals(4, $product->average_cost);
    }

    // OUT
    public function testStockOut()
    {
    	$product = factory(Product::class)->make();
    	$old_stock = $product->stock;
    	$decreased_stock = 85;

    	$product->updateStock($decreased_stock, 0, false);

    	$this->assertEquals($old_stock - $decreased_stock, $product->stock);
    }

    public function testStockOutAverageCostCorrectlyUpdated()
    {
    	$product = factory(Product::class)->make(['stock' => 4, 'average_cost' => 4]);
    	$old_stock = $product->stock;
    	$old_average = $product->average_cost;

    	$decreased_stock = 1;
    	$decreased_total_cost = $decreased_stock * 8;

    	$product->updateStock($decreased_stock, $decreased_total_cost, false, true);

    	$this->assertEquals(8/3, $product->average_cost);
    }

    public function testStockOutAverageCostCorrectlyNotUpdated()
    {
    	$product = factory(Product::class)->make();
    	$old_stock = $product->stock;
    	$old_average = $product->average_cost;

    	$decreased_stock = 4;
    	$decreased_total_cost = $decreased_stock * 2;

    	$product->updateStock($decreased_stock, $decreased_total_cost, false, false);

        $this->assertEquals($old_stock - $decreased_stock, $product->stock);
    	$this->assertEquals($old_average, $product->average_cost);
    }
}
