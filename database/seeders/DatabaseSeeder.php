<?php

namespace Database\Seeders;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        if (App::isLocal()) {
            Thread::factory()->count(5)->create()->each(function ($thread) {
                $replies = Reply::factory()->count(rand(1, 5))->raw([
                    'thread_id' => $thread->id,
                ]);

                foreach ((array) $replies as $replyData) {
                    $thread->addReply($replyData);
                }
            });
        }
    }
}
