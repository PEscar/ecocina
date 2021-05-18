<?php

use App\Models\Entity;
use App\Models\Product;
use App\Models\Recipe;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $user = factory(User::class)->create(['name' => 'Test User', 'email' => 'user@test.com']);

        // $entity = new Entity;
        // $entity->name = 'Test Entity';
        // $entity->precision = 2;
        // $entity = $user->entity()->save($entity);

        // $pizza = factory(Product::class)->create(['name' => 'Pizza Margarita', 'measure' => 1, 'detail' => 'Pizza Margarita con Olivas', 'stock' => 0, 'sales' => 1, 'shoppings' => 1, 'productions' => 1]);
        // $harina_t = factory(Product::class)->create(['name' => 'Harina de Trigo', 'measure' => 2, 'detail' => 'Harina de Trigo 000', 'stock' => 0, 'sales' => 1, 'shoppings' => 1, 'productions' => 0]);
        // $aceite_g = factory(Product::class)->create(['name' => 'Aceite de Girasol', 'measure' => 3, 'detail' => 'Aceite de Girasol', 'stock' => 0, 'sales' => 1, 'shoppings' => 1, 'productions' => 0]);
        // $pure_t = factory(Product::class)->create(['name' => 'Puré de Tomate', 'measure' => 2, 'detail' => 'Tomate Triturado', 'stock' => 0, 'sales' => 1, 'shoppings' => 1, 'productions' => 0]);
        // $muzza = factory(Product::class)->create(['name' => 'Mozzarella', 'measure' => 2, 'detail' => 'Muzzarella común', 'stock' => 0, 'sales' => 1, 'shoppings' => 1, 'productions' => 0]);
        // $olivas = factory(Product::class)->create(['name' => 'Olivas', 'measure' => 2, 'detail' => 'Olivas verdes con hueso', 'stock' => 0, 'sales' => 1, 'shoppings' => 1, 'productions' => 0]);

        // $recipe = factory(Recipe::class)->create(['name' => 'Pizza Margarita Mediana x4', 'quantity' => 4, 'detail' => 'Receta con poca muzza + 15 euros de imprevistos', 'extra_cost' => 15, 'product_id' => $pizza->id]);

        // $lines = [];

        // $lines[$harina_t->id] = ['quantity' => 1, 'detail' => 'harina p/4 pizzas'];
        // $lines[$aceite_g->id] = ['quantity' => 0.025, 'detail' => 'una cucharada'];
        // $lines[$pure_t->id] = ['quantity' => 0.150, 'detail' => 'para la salsa'];
        // $lines[$muzza->id] = ['quantity' => 0.8, 'detail' => 'la justa'];
        // $lines[$olivas->id] = ['quantity' => 0.2, 'detail' => '1 x porción'];

        // $recipe->lines()->sync($lines);
    }
}
