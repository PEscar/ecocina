<?php

use App\Models\Entity;
use App\Models\Expense;

use Illuminate\Database\Seeder;

class ExpensesSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $entity = Entity::first();

        factory(Expense::class, 10)->create(['name' => 'Alquiler']);

        Expense::where('id', '>', '0')->update(['entity_id' => $entity->id]);
    }
}
