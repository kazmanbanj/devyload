<?php

namespace Database\Factories;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $subject = $this->faker->text(15);

        // while (Thread::where('subject', $subject)->exists()) {
        //     $subject = $this->faker->text(15);
        // };

        return [
            'subject' => $subject,
            'slug' => Str::slug($subject),
            'body' => $this->faker->sentence(),
            'locked' => false,
            'user_id' => User::factory()->create()->id,
            'channel_id' => Channel::factory()->create()->id,
        ];
    }
}
