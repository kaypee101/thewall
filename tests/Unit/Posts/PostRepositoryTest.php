<?php

namespace Tests\Unit\Posts;

use App\Models\Post;
use App\Repositories\PostRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PostRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public $select;

    public $postData;

    public $updatedData;

    public function setUp(): void
    {
        parent::setUp();

        $this->select = Post::$select;
        $this->postData = [
            'title' => 'Test Post',
        ];
        $this->updatedData = [
            'title' => 'Updated Title',
        ];
    }

    /**
     * @return void
     */
    public function it_can_get_all_posts(): void
    {
        Post::factory()->count(5)->create();

        $postRepository = new PostRepository();
        $posts = $postRepository->getAll($this->select);

        $this->assertCount(5, $posts);
        $this->assertInstanceOf(Post::class, $posts->first());
    }

    /**
     * @return void
     */
    public function it_can_find_one_post(): void
    {
        $posts = Post::factory()->count(5)->create();
        $randomPost = $posts[mt_rand(0, $posts->count() - 1)];

        $postRepository = new PostRepository();
        $post = $postRepository->findById($this->select, $randomPost->id);

        $this->assertInstanceOf(Post::class, $post);
    }

    /**
     * @return void
     */
    public function it_can_create_a_post(): void
    {
        $postRepository = new PostRepository();

        $createdPost = $postRepository->create($this->select, $this->postData);

        $this->assertInstanceOf(Post::class, $createdPost);
        $this->assertEquals($this->postData['title'], $createdPost->title);
    }

    /**
     * @return void
     */
    public function it_can_update_a_post(): void
    {
        $postRepository = new PostRepository();

        $post = $postRepository->create($this->select, $this->postData);
        $updatedPost = $postRepository->update($post, $this->updatedData);

        $this->assertInstanceOf(Post::class, $updatedPost);
        $this->assertEquals($this->updatedData['title'], $updatedPost->title);
        $this->assertEquals(Str::slug($this->updatedData['title']), $updatedPost->slug);
    }

    /**
     * @return void
     */
    public function it_can_delete_a_post(): void
    {
        $postRepository = new PostRepository();

        $post = $postRepository->create($this->select, $this->postData);
        $postRepository->delete($post);

        $this->assertSoftDeleted('posts', ['id' => $post->id]);
    }
}
