<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;
use App\Models\User;
use App\Models\Post;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $nb_comments = (int)$this->command->ask("How many comments do you want to generate?", 1500);

        $users = User::all();
        $posts = Post::all();

        // if we don't have posts, don't create comments and return a message
        if (count($posts)==0) {
            $this->command->info("There is no post where you can put these comments.");
            return;
        }
        // if we don't have users, don't create comments and return a message
        if (count($users)==0) {
            $this->command->info("There is no user on the database, please create some!");
            return;
        }

        Comment::factory($nb_comments)->make()->each(function($comment) use ($users, $posts) {
            $comment->posts_id = $posts->random()->id;
            $comment->users_id = $users->random()->id;
            $comment->save();
        });
    }
}
