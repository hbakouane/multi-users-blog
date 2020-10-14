<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\categories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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

        $first_user = User::all()->first();
        $last_user = User::all()->last();
        $first_category = categories::all()->first();
        $last_category = categories::all()->last();

        return [
            'title' => $title,
            'slug' => $slug,
            'body' => $this->faker->paragraph(20),
            'users_id' => $this->faker->numberBetween($first_user->id, $last_user->id),
            'categories_id' => $this->faker->numberBetween(1, 3),
            'visibility' => true,
            'post_image' => $this->faker->image('public/storage/images/posts_images/'),
            'comments' => $this->faker->boolean(80), // The change of getting true is 80%
            'views' => 0
        ];

    }
}
