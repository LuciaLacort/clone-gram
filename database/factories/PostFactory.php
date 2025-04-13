<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(5),
            'description' => $this->faker->sentence(20),
            'image' => $this->faker->uuid() . '.jpg',
            'user_id' => $this->faker->randomElement([1, 3, 4, 5, 6]),
        ];
    }
}
