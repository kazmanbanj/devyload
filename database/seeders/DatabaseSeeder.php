<?php

namespace Database\Seeders;

use Notification;
use App\Models\User;
use App\Models\Reply;
use Ramsey\Uuid\Uuid;
use App\Models\Thread;
use App\Models\Channel;
use Illuminate\Database\Seeder;
use Database\Seeders\FeaturesSeeder;
// use Illuminate\Notifications\DatabaseNotification;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Channel::factory(100)->create();
        User::factory(200)->create();
        Thread::factory(100)->create();
        Reply::factory(100)->create();

        $this->call([
            FeaturesSeeder::class,
        ]);

        // Notification::create([
        //     'id' => Uuid::uuid4()->toString(),
        //     'type' => 'App\Notifications\ThreadWasUpdated',
        //     'notifiable_type' => function () {
        //         return auth()->id() ?: factory('App\User')->create()->id;
        //     },
        //     'notifiable_id' => 'App\User',
        //     'data' => ['title' => 'this is the body of the notification']
        // ]);
    }
}
