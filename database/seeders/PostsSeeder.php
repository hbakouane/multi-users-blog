<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\categories;
use App\Models\Post;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $nb_posts = (int)$this->command->ask("How many posts do you want to generate?", 50);

        $users = User::all();

        // if we don't have users, don't create posts and return a message
        if (count($users)==0) {
            $this->command->info("There is no user on the database, please create some!");
            return;
        }

        $categories = categories::all();
        Post::factory($nb_posts)->make()->each(function ($post) use ($users, $categories) {
            $post->users_id = $users->random()->id;
            $post->categories_id = $categories->random()->id;
            $post->save();
        });
    }
}
