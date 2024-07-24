<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Post;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_name' => User::inRandomOrder()->first()->value('name'),
            'post_id' => Post::inRandomOrder()->first()->id,
            'text' => $this->faker->text(200)
        ];
    }
}
