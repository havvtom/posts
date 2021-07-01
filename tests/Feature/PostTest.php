<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Post;
use App\Models\User;

class PostTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_an_authenticated_user_can_add_a_post()
    {
        $attributes = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph
        ];

        $this->actingAs(User::factory()->create());

        $this->post('/posts', $attributes);

        $this->assertDatabaseHas('posts', $attributes );

        $this->get('/posts')->assertSee($attributes['body']);
    }

    public function test_an_authenticated_user_can_update_their_post()
    {
        $this->actingAs(User::factory()->create());

        $post = Post::factory()->create(['user_id' => auth()->id()]);

        $this->patch("/posts/{$post->id}", ['title' => 'Title changed', 'body' => 'Body changed' ]);

        $this->assertDatabaseHas('posts', ['body' => 'Body changed']);
    }

    public function test_an_authenticated_user_can_delete_their_post()
    {
        $this->actingAs(User::factory()->create());

        $post = auth()->user()->posts()->create( Post::factory()->raw() );

        $this->delete("/posts/{$post->id}");

        $this->assertDatabaseMissing('posts', $post->getAttributes());
    }

    public function test_an_authenticated_user_cannot_update_posts_of_others()
    {
        $this->actingAs( User::factory()->create() );

        $post = Post::factory()->create(['user_id' => auth()->id()]);

        $this->actingAs( $john = User::factory()->create() );

        $this->patch("/posts/{$post->id}", ['title' => 'To be updated', 'body' => 'Changed'])->assertStatus(403);

    }

    public function test_an_authenticated_user_cannot_delete_posts_of_others()
    {
        $this->actingAs( User::factory()->create() );

        $post = Post::factory()->create(['user_id' => auth()->id()]);

        $this->actingAs( $john = User::factory()->create() );

        $this->delete("/posts/{$post->id}", ['title' => 'To be updated', 'body' => 'Changed'])->assertStatus(403);

    }

    public function test_a_post_requires_a_title()
    {
        $this->actingAs(User::factory()->create());

        $attributes = Post::factory()->raw(['title' => '', ]);

        $this->post('/posts', $attributes)->assertSessionHasErrors('title');
    }

    public function test_a_post_requires_a_body()
    {
        $this->actingAs(User::factory()->create()); 

        $attributes = Post::factory()->raw(['body' => '']);

        $this->post('/posts', $attributes)->assertSessionHasErrors('body');
    }
    
    public function test_a_user_can_browse_posts()
    {
        $response = $this->get('/posts');

        $response->assertStatus(200);

        $this->actingAs( User::factory()->create() );

        $post = Post::factory()->create(['user_id' => auth()->id()]);

        $this->get('/posts')->assertSee( $post->title );
    }
}
