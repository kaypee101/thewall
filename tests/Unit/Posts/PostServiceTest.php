<?php

namespace Tests\Unit\Posts;

use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\Admin\AdminPostService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostServiceTest extends TestCase
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
        $postRepositoryMock = $this->createMock(PostRepository::class);
        $postRepositoryMock->method('getAll')->willReturn(collect([Post::factory()->create()]));

        $postService = new AdminPostService($postRepositoryMock);
        $posts = $postService->getAll($this->select);

        $this->assertInstanceOf(Post::class, $posts->first());
    }

    /**
     * @return void
     */
    public function it_can_find_one_posts(): void
    {
        $postRepositoryMock = $this->createMock(PostRepository::class);
        $postRepositoryMock->method('findById')->willReturn(Post::factory()->create());

        $postService = new AdminPostService($postRepositoryMock);
        $posts = $postService->findById($this->select, 1);

        $this->assertInstanceOf(Post::class, $posts);
    }

    /**
     * @return void
     */
    public function it_can_create_a_post(): void
    {
        $mockedPostModel = Post::factory()->create();
        $mockedPostData = [
            'title' => $mockedPostModel->title,
        ];
        $postRepositoryMock = \Mockery::mock(PostRepository::class);
        $postRepositoryMock
            ->shouldReceive('create')
            ->once()
            ->andReturn($mockedPostModel);

        $postService = new AdminPostService($postRepositoryMock);
        $createdPost = $postService->create($this->select, $mockedPostData);

        $this->assertInstanceOf(Post::class, $createdPost);
        $this->assertEquals($mockedPostData['title'], $createdPost->title);

        \Mockery::close();
    }

    /**
     * @return void
     */
    public function it_can_update_a_post(): void
    {
        $post = Post::factory()->create();
        $mockedPostModel = Post::factory()->create();
        $mockedPostData = [
            'title' => $mockedPostModel->title,
        ];
        $postRepositoryMock = \Mockery::mock(PostRepository::class);
        $postService = new AdminPostService($postRepositoryMock);

        $postRepositoryMock
            ->shouldReceive('update')
            ->once()
            ->with($post, $mockedPostData)
            ->andReturn($mockedPostModel);

        $result = $postService->update($post, $mockedPostData);

        $this->assertEquals($mockedPostModel, $result);

        \Mockery::close();
    }

    /**
     * @return void
     */
    public function it_can_delete_a_post(): void
    {
        $mockedPostModel = Post::factory()->create();
        $postRepositoryMock = \Mockery::mock(PostRepository::class);

        $postRepositoryMock
            ->shouldReceive('findById')
            ->with($this->select, $mockedPostModel->id)
            ->andReturn($mockedPostModel);

        $postRepositoryMock
            ->shouldReceive('delete')
            ->with($mockedPostModel)
            ->andReturn(true);

        $postService = new AdminPostService($postRepositoryMock);

        $deletedPost = $postService->delete($this->select, $mockedPostModel->id);

        $this->assertNull($deletedPost);

        \Mockery::close();
    }
}
