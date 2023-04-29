<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TopicFactory extends Factory
{

    public function definition()
    {
       $sentence = fake()->sentence();

        return [
            'title' => $sentence,
            'content' => fake()->text(),
            'excerpt' => $sentence,
            'user_id' => fake()->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),
            'category_id' => fake()->randomElement([1, 2, 3, 4]),
        ];
    }
}
