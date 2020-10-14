<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\categories;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if ($this->command->confirm('Do you want to refresh the databse?', false)) {
            $this->command->call("migrate:refresh");
            $this->command->info("Database was refreshed");
        }

        $this->call([
            CategoriesSeeder::class,
            UsersSeeder::class,
            PostsSeeder::class,
            CommentsSeeder::class
        ]);
    }
}
