<?php

use App\Models\Entity;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseLine;
use Illuminate\Database\Seeder;

class PurchaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $entity = Entity::first();

        factory(Purchase::class, 5)->create()->each(function ($purchasedeliverynote){
            Product::purchases()->get()->random(2)->each(function ($item, $key) use ($purchasedeliverynote) {
                factory(PurchaseLine::class)->create(['product_id' => $item->id, 'header_id' => $purchasedeliverynote->id]);
            });
        });

        Purchase::where('id', '>', '0')->update(['entity_id' => $entity->id]);
        PurchaseLine::where('id', '>', '0')->update(['entity_id' => $entity->id]);
    }
}
