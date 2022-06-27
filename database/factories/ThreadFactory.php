<?php

namespace Database\Factories;

use App\Models\Thread;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(15);
        
        while (Thread::where('title', $title)->exists()) {
            $title = $this->faker->text(15);
        };

        return [
            'user_id' => rand(1, 200),
            'channel_id' => rand(1, 20),
            'title' => $title,
            'body' => $this->faker->sentence(),
            'slug' => Str::slug($title),
        ];
    }
}
