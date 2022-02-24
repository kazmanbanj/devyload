<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Reply;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReplyTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function test_a_reply_has_an_owner()
    {
        $reply = Reply::factory(200)->create();

        $this->assertInstanceOf(Collection::class, $reply->creator);
    }
}
