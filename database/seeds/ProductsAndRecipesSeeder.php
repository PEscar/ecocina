<?php

use App\Models\Entity;
use App\Models\Product;
use App\Models\Recipe;
use Illuminate\Database\Seeder;

class ProductsAndRecipesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$entity = Entity::first();

        $pizza = factory(Product::class)->create(['name' => 'Pizza Margarita', 'measure' => 1, 'detail' => 'Pizza Margarita con Olivas', 'stock' => 0, 'sales' => 1, 'shoppings' => 1, 'productions' => 1]);
        $harina_t = factory(Product::class)->create(['name' => 'Harina de Trigo', 'measure' => 2, 'detail' => 'Harina de Trigo 000', 'stock' => 0, 'sales' => 1, 'shoppings' => 1, 'productions' => 0]);
        $aceite_g = factory(Product::class)->create(['name' => 'Aceite de Girasol', 'measure' => 3, 'detail' => 'Aceite de Girasol', 'stock' => 0, 'sales' => 1, 'shoppings' => 1, 'productions' => 0]);
        $pure_t = factory(Product::class)->create(['name' => 'Puré de Tomate', 'measure' => 2, 'detail' => 'Tomate Triturado', 'stock' => 0, 'sales' => 1, 'shoppings' => 1, 'productions' => 0]);
        $muzza = factory(Product::class)->create(['name' => 'Mozzarella', 'measure' => 2, 'detail' => 'Muzzarella común', 'stock' => 0, 'sales' => 1, 'shoppings' => 1, 'productions' => 0]);
        $olivas = factory(Product::class)->create(['name' => 'Olivas', 'measure' => 2, 'detail' => 'Olivas verdes con hueso', 'stock' => 0, 'sales' => 1, 'shoppings' => 1, 'productions' => 0]);

        $recipe = factory(Recipe::class)->create(['name' => 'Pizza Margarita Mediana x4', 'quantity' => 4, 'detail' => 'Receta con poca muzza + 15 euros de imprevistos', 'extra_cost' => 15, 'product_id' => $pizza->id]);

        $lines = [];

        $lines[$harina_t->id] = ['quantity' => 1, 'detail' => 'harina p/4 pizzas', 'entity_id' => $entity->id];
        $lines[$aceite_g->id] = ['quantity' => 0.025, 'detail' => 'una cucharada', 'entity_id' => $entity->id];
        $lines[$pure_t->id] = ['quantity' => 0.150, 'detail' => 'para la salsa', 'entity_id' => $entity->id];
        $lines[$muzza->id] = ['quantity' => 0.8, 'detail' => 'la justa', 'entity_id' => $entity->id];
        $lines[$olivas->id] = ['quantity' => 0.2, 'detail' => '1 x porción', 'entity_id' => $entity->id];

        $recipe->lines()->sync($lines);
    
        // UPDATE ENTRITYS IDS
        Product::where('id', '>', '0')->update(['entity_id' => $entity->id]);
        Recipe::where('id', '>', '0')->update(['entity_id' => $entity->id]);
    }
}
