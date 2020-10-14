<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $nb_users = (int)$this->command->ask("How many users do you want to generate?", 15);

        User::factory($nb_users)->create();
    }
}
