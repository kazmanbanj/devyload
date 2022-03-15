<?php

namespace Database\Seeders;

use App\Models\Channel;
use App\Models\User;
use App\Models\Thread;
use App\Models\Reply;
use Illuminate\Database\Seeder;

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
    }
}
