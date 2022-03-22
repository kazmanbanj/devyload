<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReplyFactory extends Factory
{    
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'thread_id' => rand(1, 100),
            'user_id' => rand(1, 200),
            'body' => $this->faker->sentence(),
        ];
    }
}
