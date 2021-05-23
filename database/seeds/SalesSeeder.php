<?php

use App\Models\Entity;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleLine;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $entity = Entity::first();

        factory(Sale::class, 1)->create()->each(function ($purchasedeliverynote){
            Product::all()->random(3)->each(function ($item, $key) use ($purchasedeliverynote) {
                factory(SaleLine::class)->create(['product_id' => $item->id, 'header_id' => $purchasedeliverynote->id]);
            });
        });

        Sale::where('id', '>', '0')->update(['entity_id' => $entity->id]);
        SaleLine::where('id', '>', '0')->update(['entity_id' => $entity->id]);
    }
}
