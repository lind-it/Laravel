<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'autor_name' => User::inRandomOrder()->first()->name,
            'title' => $this->faker->words(rand(3, 8), true),
            'description' => $this->faker->text(200),
            'text' => $this->faker->text(4000)
        ];
    }
}
