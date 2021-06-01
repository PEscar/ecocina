<?php

namespace Tests\Integration;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleLine;
use Illuminate\Foundation\Testing\DatabaseTransactions; 
use Tests\TestCase;

class SaleTest extends TestCase
{
    use DatabaseTransactions;

    public function testStockMovementOutGeneratedWhenSaleCreated()
    {
        $product = factory(Product::class)->create();

        $sale = factory(sale::class)->create();

        $lines = [];
        $lines[$product->id] = factory(SaleLine::class)->make()->toArray();

        $sale->lines()->attach($lines);

        $this->assertDatabaseHas('stock_movements', [
            'parentable_type' => Sale::class,
            'parentable_id' => $sale->id,
        ]);

        $line = $sale->lines()->where('product_id', $product->id)->first();

        $this->assertDatabaseHas('stock_movement_lines', [
            'type' => 'out',
            'parentable_type' => SaleLine::class,
            'parentable_id' => $line->pivot->id,
            'product_id' => $product->id,
            'quantity' => $line->pivot->quantity,
        ]);
    }

    public function testStockMovementDeletedWhenSaleDeleted()
    {
        $product = factory(Product::class)->create();
        $sale = factory(Sale::class)->create();

        $lines = [];
        $lines[$product->id] = factory(SaleLine::class)->make()->toArray();

        $sale->lines()->attach($lines);

        $line = $sale->lines()->where('product_id', $product->id)->first();

        $sale->delete();

        $this->assertDatabaseMissing('stock_movements', [
            'parentable_type' => Sale::class,
            'parentable_id' => $sale->id,
        ]);

        $this->assertDatabaseMissing('stock_movement_lines', [
            'type' => 'out',
            'parentable_type' => SaleLine::class,
            'parentable_id' => $line->pivot->id,
            'product_id' => $product->id,
            'quantity' => $line->pivot->quantity,
        ]);
    }

    public function testProductStockAndAverageCostCorrectlyUpdatedWhenSaleCreated()
    {
        $product = factory(Product::class)->create();
        $sale = factory(Sale::class)->create();

        $old_stock = $product->stock;
        $old_average = $product->average_cost;

        $lines = [];
        $lines[$product->id] = factory(SaleLine::class)->make(['quantity' => ($product->stock - 0.2)])->toArray();

        $sale->lines()->attach($lines);
        $product->refresh();
        $line = $sale->lines()->where('product_id', $product->id)->first();

        $this->assertEquals(round($old_stock - $line->pivot->quantity, 3), $product->stock);
        $this->assertEquals(round($old_average, 3), round($product->average_cost, 3));
    }

    public function testProductStockCorrectlyUpdatedWhenSaleDeleted()
    {
        $product = factory(Product::class)->create();
        $old_stock = $product->stock;

        $lines = [];
        $lines[$product->id] = factory(SaleLine::class)->make()->toArray();

        $sale = factory(Sale::class)->create();
        $sale->lines()->attach($lines);
        $product->refresh();

        $this->assertNotEquals($old_stock, $product->stock);

        $sale->delete();
        $product->refresh();

        $this->assertEquals($old_stock, $product->stock);
    }
}
