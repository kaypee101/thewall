<?php

namespace Tests\Unit\Posts;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PostModelTest extends TestCase
{
    use RefreshDatabase;

    public $postData = [
        'title' => 'Test Post',
    ];

    public $updatedData = [
        'title' => 'Updated Post',
    ];

    /**
     * @return void
     */
    public function test_can_create_a_post(): void
    {
        $post = Post::create($this->postData);

        $this->assertInstanceOf(Post::class, $post);
        $this->assertEquals($this->postData['title'], $post->title);
        $this->assertEquals(Str::slug($this->postData['title']), $post->slug);

        $this->assertDatabaseHas('posts', $this->postData);
    }

    /**
     * @return void
     */
    public function test_can_update_a_post(): void
    {
        $post = Post::create($this->postData);
        $post->update($this->updatedData);

        $this->assertEquals($this->updatedData['title'], $post->title);
        $this->assertEquals(Str::slug($this->updatedData['title']), $post->slug);

        $this->assertDatabaseHas('posts', $this->updatedData);
    }

    /**
     * @return void
     */
    public function test_can_delete_a_post(): void
    {
        $post = Post::create($this->postData);
        $post->delete();

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }
}
