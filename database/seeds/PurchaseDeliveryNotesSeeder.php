<?php

use App\Models\Entity;
use App\Models\Product;
use App\Models\PurchaseDeliveryNote;
use App\Models\PurchaseDeliveryNoteLine;
use Illuminate\Database\Seeder;

class PurchaseDeliveryNotesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $entity = Entity::first();
        // SEED PURCHASE DELIVERY NOTES
        $purchasedeliverynote = factory(PurchaseDeliveryNote::class)->create(['entity_id' => $entity->id]);
        $purchasedeliverynote = factory(PurchaseDeliveryNote::class)->create();

        // SEED PURCHASE DELIVERY NOTES LINES
        factory(PurchaseDeliveryNoteLine::class)->create(['product_id' => Product::all()->random()->id,'header_id' => $purchasedeliverynote->id, 'entity_id' => $entity->id]);
        factory(PurchaseDeliveryNoteLine::class)->create(['product_id' => Product::all()->random()->id,'header_id' => $purchasedeliverynote->id, 'entity_id' => $entity->id]);
        PurchaseDeliveryNoteLine::where('id', '>', '0')->update(['entity_id' => $entity->id]);

        factory(PurchaseDeliveryNoteLine::class)->create(['product_id' => Product::all()->random()->id, 'header_id' => $purchasedeliverynote->id]);
        factory(PurchaseDeliveryNoteLine::class)->create(['product_id' => Product::all()->random()->id, 'header_id' => $purchasedeliverynote->id]);
        factory(PurchaseDeliveryNoteLine::class)->create(['product_id' => Product::all()->random()->id, 'header_id' => $purchasedeliverynote->id]);
        factory(PurchaseDeliveryNoteLine::class)->create(['product_id' => Product::all()->random()->id, 'header_id' => $purchasedeliverynote->id]);
        factory(PurchaseDeliveryNoteLine::class)->create(['product_id' => Product::all()->random()->id, 'header_id' => $purchasedeliverynote->id]);
        factory(PurchaseDeliveryNoteLine::class)->create(['product_id' => Product::all()->random()->id, 'header_id' => $purchasedeliverynote->id]);
        factory(PurchaseDeliveryNoteLine::class)->create(['product_id' => Product::all()->random()->id, 'header_id' => $purchasedeliverynote->id]);
        factory(PurchaseDeliveryNoteLine::class)->create(['product_id' => Product::all()->random()->id, 'header_id' => $purchasedeliverynote->id]);
        factory(PurchaseDeliveryNoteLine::class)->create(['product_id' => Product::all()->random()->id, 'header_id' => $purchasedeliverynote->id]);

        PurchaseDeliveryNote::where('id', '>', '0')->update(['entity_id' => $entity->id]);
        PurchaseDeliveryNoteLine::where('id', '>', '0')->update(['entity_id' => $entity->id]);
    }
}
