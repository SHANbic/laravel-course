<?php

namespace Tests\Feature;

use App\BlogPost;
use App\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testEmptyBlogPostListWhenNoBlogPostInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('the list is empty');
    }

    public function testSeeOneBlogPostWithComments()
    {
        $post = $this->createDummyBlogPost();
        factory(Comment::class, 4)->create([
            'blog_post_id' => $post->id
        ]);
        $response = $this->get('/posts');

        $response->assertSeeText('4 comments');
    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'at least 10 characters'
        ];

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'the blog post was created');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'hey',
            'content' => 'there'
        ];

        $this->actingAs($this->user())
            ->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts',  [
            'title' => $post->title,
            'content' => $post->content
        ]);

        $params = [
            'title' => 'brand new title',
            'content' => 'some new content'
        ];

        $this->actingAs($user)
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog Post was updated !');
        $this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'brand new title',
            'content' => 'some new content'
        ]);
    }

    public function testDelete()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);

        $this->actingAs($user)
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog Post was deleted !');
        //$this->assertDatabaseMissing('blog_posts', $post->toArray());
        $this->assertSoftDeleted('blog_posts', [
            'title' => $post->title,
            'content' => $post->content
        ]);
    }

    private function createDummyBlogPost($userId = null): BlogPost
    {
        // $post = new BlogPost();
        // $post->title = "new blog post";
        // $post->content = "testing blog post";
        // $post->save();

        return factory(BlogPost::class)->states('new-title')->create([
            'user_id' => $userId ?? $this->user()->id
        ]);

        // return $post;
    }
}
