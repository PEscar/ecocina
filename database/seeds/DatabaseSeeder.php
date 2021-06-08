<?php

use App\Models\Entity;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $user = factory(User::class)->create(['name' => 'Test User', 'email' => 'user@test.com']);

        $entity = new Entity;
        $entity->name = 'Test Entity';
        $entity->precision = 2;
        $entity = $user->entity()->save($entity);

        $this->call([
            ProductAndRecipeSeeder::class,
            PurchaseSeeder::class,
            // SaleSeeder::class,
            ExpenseSeeder:: class,
        ]);
    }
}
