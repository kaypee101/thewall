<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\InertiaRenderHelper;
use App\Helpers\LoggingHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostFormRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\Admin\AdminPostService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public $title;
    public $select;
    private $adminPostService;

    public function __construct(
        AdminPostService $adminPostService,
    ) {
        $this->title = Post::TITLE;
        $this->select = Post::$select;
        $this->adminPostService = $adminPostService;
    }

    /**
     * @return \Inertia\Response
     */
    public function index(): \Inertia\Response
    {
        try {
            $posts = $this->adminPostService->paginate($this->select, 5);
            $posts = PostResource::collection($posts);
            return InertiaRenderHelper::render('Admin/Posts/Index', [
                'title' => $this->title,
                'posts' => $posts,
            ]);
        } catch (ModelNotFoundException $e) {
            LoggingHelper::logger('Model not found', 'error');
            LoggingHelper::logger($e->getMessage(), 'error');
            throw new ModelNotFoundException($e->getMessage());
        } catch (Exception $e) {
            LoggingHelper::logger('Exception', 'error');
            LoggingHelper::logger($e->getMessage(), 'error');
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return \Inertia\Response
     */
    public function create(): \Inertia\Response
    {
        return InertiaRenderHelper::render('Admin/Posts/Create', [
            'title' => $this->title,
        ]);
    }

    /**
     * @param PostFormRequest $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PostFormRequest $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $request->validated();
            $this->adminPostService->create($this->select, $data);
            $message = [
                'subject' => $this->title,
                'details' => 'Created Successfully',
            ];
            return InertiaRenderHelper::redirect(
                route('admin.posts.index'),
                $message
            );
        } catch (Exception $e) {
            LoggingHelper::logger('Exception', 'error');
            LoggingHelper::logger($e->getMessage(), 'error');
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param int $postId
     * 
     * @return \Inertia\Response
     */
    public function edit(int $postId): \Inertia\Response
    {
        try {
            $post = $this->adminPostService->findById($this->select, $postId);
            $post = new PostResource($post);
            return InertiaRenderHelper::render('Admin/Posts/Edit', [
                'title' => $this->title,
                'post' => $post,
            ]);
        } catch (ModelNotFoundException $e) {
            LoggingHelper::logger('Model not found', 'error');
            LoggingHelper::logger($e->getMessage(), 'error');
            throw new ModelNotFoundException($e->getMessage());
        } catch (Exception $e) {
            LoggingHelper::logger('Exception', 'error');
            LoggingHelper::logger($e->getMessage(), 'error');
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param PostFormRequest $request
     * @param int $postId
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PostFormRequest $request, int $postId): \Illuminate\Http\RedirectResponse
    {
        try {
            $data = $request->validated();
            $post = $this->adminPostService->findById($this->select, $postId);
            $this->adminPostService->update($post, $data);
            $message = [
                'subject' => $this->title,
                'details' => 'Updated Successfully',
            ];
            return InertiaRenderHelper::redirect(
                route('admin.posts.index'),
                $message
            );
        } catch (ModelNotFoundException $e) {
            LoggingHelper::logger('Model not found', 'error');
            LoggingHelper::logger($e->getMessage(), 'error');
            throw new ModelNotFoundException($e->getMessage());
        } catch (Exception $e) {
            LoggingHelper::logger('Exception', 'error');
            LoggingHelper::logger($e->getMessage(), 'error');
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param int $postId
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $postId): \Illuminate\Http\RedirectResponse
    {
        try {
            $this->adminPostService->delete($this->select, $postId);
            $message = [
                'subject' => $this->title,
                'details' => 'Deleted Successfully',
            ];
            return InertiaRenderHelper::redirect(
                route('admin.posts.index'),
                $message
            );
        } catch (ModelNotFoundException $e) {
            LoggingHelper::logger('Model not found', 'error');
            LoggingHelper::logger($e->getMessage(), 'error');
            throw new ModelNotFoundException($e->getMessage());
        } catch (Exception $e) {
            LoggingHelper::logger('Exception', 'error');
            LoggingHelper::logger($e->getMessage(), 'error');
            throw new Exception($e->getMessage());
        }
    }
}
