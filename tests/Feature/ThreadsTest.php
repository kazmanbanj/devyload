<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Thread;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Factories\Factory;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = Thread::factory()->create();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

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
        $this->get('/threads/' . $this->thread->id)->assertSee($this->thread->title);
    }

    public function a_user_can_read_replies_associated_with_a_thread()
    {
        $reply = Reply::factory()->create(['thread_id' => $this->thread->id]);

        $response = $this->get('/threads/' . $this->thread->id)->assertSee($reply->body);
    }
}
