<?php

namespace Tests\Feature\Posts;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public $mockedAdmin;
    public $select;
    public $createPost;
    public $createPostData;
    public $updatePostData;

    public function setUp(): void
    {
        parent::setUp();

        $this->mockedAdmin = User::factory()->create();
        $this->select = Post::$select;
        $this->createPost = Post::factory()->create(['title' => 'Create Post']);
        $this->createPostData = [
            'title' => 'Create Post Data',
        ];
        $this->updatePostData = [
            'title' => 'Updated Post Data',
        ];
    }

    /**
     * @return void
     */
    public function it_can_get_all_posts(): void
    {
        $response = $this->actingAs($this->mockedAdmin)->get(route('admin.posts.index'));

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function it_can_find_one_posts(): void
    {

        $response = $this->actingAs($this->mockedAdmin)->get(route('admin.posts.edit', ['postId' => $this->createPost->id]));

        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function it_can_create_a_post(): void
    {

        $response = $this->actingAs($this->mockedAdmin)->post(route('admin.posts.store'), $this->createPostData);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.posts.index'));
    }

    /**
     * @return void
     */
    public function it_can_update_a_post(): void
    {
        $response = $this->actingAs($this->mockedAdmin)->put(route('admin.posts.update', ['postId' => $this->createPost->id]), $this->updatePostData);

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.posts.index'));
    }

    /**
     * @return void
     */
    public function it_can_delete_a_post(): void
    {
        $response = $this->actingAs($this->mockedAdmin)->delete(route('admin.posts.destroy', ['postId' => $this->createPost->id]));

        $response->assertStatus(302);
        $response->assertRedirect(route('admin.posts.index'));
    }
}
