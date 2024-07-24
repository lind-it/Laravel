<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
                ->count(10)
                ->has(Post::factory()
                            ->count(3)
                            ->state(function(array $attributes, User $user)
                                    {
                                        return [
                                            'autor_name' => $user->name
                                        ];
                                    }
                                )
                    )
                ->create();
    }
}
