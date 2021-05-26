<?php

namespace Tests\Integration;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseLine;
use Illuminate\Foundation\Testing\DatabaseTransactions; 
use Tests\TestCase;

class PurchaseTest extends TestCase
{
	use DatabaseTransactions;

    public function testStockMovementGeneratedWhenPurchaseCreated()
    {
    	$product = factory(Product::class)->create();

        $purchase = factory(Purchase::class)->create();

        $lines = [];
        $lines[$product->id] = [
            'quantity' => 18,
            'price_per_unit' => 2,
            'total' => 18 * 2,
            'entity_id' => session('user.entity_id'),
        ];

        $purchase->lines()->attach($lines);

    	$this->assertDatabaseHas('stock_movements', [
            'parentable_type' => Purchase::class,
            'parentable_id' => $purchase->id,
        ]);

        $line = $purchase->lines()->where('product_id', $product->id)->first();

        $this->assertDatabaseHas('stock_movement_lines', [
            'type' => 'in',
            'parentable_type' => PurchaseLine::class,
            'parentable_id' => $line->pivot->id,
            'product_id' => $product->id,
            'quantity' => 18,
        ]);
    }

    public function testStockMovementDeletedWhenPurchaseDeleted()
    {
        $product = factory(Product::class)->create();
        $purchase = factory(Purchase::class)->create();

        $lines = [];
        $lines[$product->id] = [
            'quantity' => 18,
            'price_per_unit' => 2,
            'total' => 18 * 2,
            'entity_id' => session('user.entity_id'),
        ];

        $purchase->lines()->attach($lines);

        $line = $purchase->lines()->where('product_id', $product->id)->first();

        $purchase->delete();

        $this->assertDatabaseMissing('stock_movements', [
            'parentable_type' => Purchase::class,
            'parentable_id' => $purchase->id,
        ]);

        $this->assertDatabaseMissing('stock_movement_lines', [
            'type' => 'in',
            'parentable_type' => PurchaseLine::class,
            'parentable_id' => $line->pivot->id,
            'product_id' => $product->id,
            'quantity' => 18,
        ]);
    }

    public function testProductStockAndAverageCostCorrectlyUpdatedWhenPurchaseCreated()
    {
        $product = factory(Product::class)->create();
        $old_stock = $product->stock;
        $old_average = $product->average_cost;

        $lines = [];
        $lines[$product->id] = [
            'quantity' => 18,
            'price_per_unit' => 2,
            'total' => 18 * 2,
            'entity_id' => session('user.entity_id'),
        ];

        factory(Purchase::class)->create()->lines()->attach($lines);
        $product->refresh();

        $this->assertEquals($old_stock + 18, $product->stock);
        $this->assertEquals(round((($old_average * $old_stock) + 36) / ($old_stock + 18), 3), round($product->average_cost, 3));
    }

    public function testProductStockAndAverageCostCorrectlyUpdatedWhenPurchaseDeleted()
    {
        $product = factory(Product::class)->create();
        $old_stock = $product->stock;
        $old_average = $product->average_cost;

        $lines = [];
        $lines[$product->id] = [
            'quantity' => 18,
            'price_per_unit' => 2,
            'total' => 18 * 2,
            'entity_id' => session('user.entity_id'),
        ];

        $purchase = factory(Purchase::class)->create();
        $purchase->lines()->attach($lines);
        $product->refresh();

        $this->assertNotEquals($old_stock, $product->stock);
        $this->assertNotEquals($old_average, $product->average_cost);

        $purchase->delete();
        $product->refresh();

        $this->assertEquals($old_stock, $product->stock);
        $this->assertEquals($old_average, $product->average_cost);
    }
}
