<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\categories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Provider\Image;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $title = $this->faker->sentence();
        $slug = Str::slug($title, '-');
        $users = User::all();
        $categories = categories::all();

        return [
            'title' => $title,
            'slug' => $slug,
            'body' => $this->faker->paragraph(20),
            'users_id' => $users->random()->id,
            'categories_id' => $categories->random()->id,
            'visibility' => true,
            'post_image' => $this->faker->image('public/storage/images/posts_images'),
            'comments' => $this->faker->boolean(80), // The chance of getting true is 80%
            'views' => 0
        ];

    }
}
