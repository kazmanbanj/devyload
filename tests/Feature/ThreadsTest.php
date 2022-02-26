<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Thread;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations, RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = Thread::factory(450)->create();
        $this->user = User::factory(500)->create();
    }

    /** @test */
    public function a_user_can_browse_threads()
    {
        $this->get('/threads')->assertStatus(200);
    }

    /** @test */
    public function a_user_can_see_title()
    {
        $this->get('/threads')->assertSee($this->thread->title);
    }

     /** @test */
    public function a_user_can_see_a_particular_thread()
    {        
        $this->get('/threads/{$this->thread->id}')->assertSee($this->thread->title);
    }

    public function a_user_can_read_replies_associated_with_a_thread()
    {
        $reply = Reply::factory(400)->create(['thread_id' => $this->thread->id]);
        // $reply = create(new Reply);

        $response = $this->get('/threads/{$this->thread->id}')->assertSee($reply->body);
    }
}
