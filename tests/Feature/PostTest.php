<?php

namespace Tests\Feature;

use App\BlogPost;
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

    public function testSeeOneBlogPostWhenOneBlogPostInDatabase()
    {
        // Arrange part
        $post = $this->createDummyBlogPost();

        //Act part
        $response = $this->get('/posts');

        //Assert part
        $response->assertSeeText('new blog post');
        $response->assertSeeText('No comments yet !');
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'new blog post'
        ]);
    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'at least 10 characters'
        ];

        $this->post('/posts', $params)
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

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();

        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'new blog post',
            'content' => "testing blog post"
        ]);

        $params = [
            'title' => "brand new title",
            'content' => 'some new content'
        ];

        $this->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog Post was updated !');
        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'new blog post',
            'content' => "testing blog post"
        ]);
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'brand new title',
            'content' => "some new content"
        ]);
    }

    public function testDeleteValid()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'new blog post',
            'content' => "testing blog post"
        ]);

        $this->delete("/posts/{$post->id}")
        ->assertStatus(302)
        ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog Post was deleted !');
        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'new blog post',
            'content' => "testing blog post"
        ]);
    }
    
    private function createDummyBlogPost(): BlogPost
    {
        $post = new BlogPost();
        $post->title = "new blog post";
        $post->content = "testing blog post";
        $post->save();
        
        return $post;
    }
}
