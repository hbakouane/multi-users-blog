<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\categories;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $nb_categories = (int)$this->command->ask("How many categories do you want to generate?", 20);

        categories::factory($nb_categories)->create();
    }
}
