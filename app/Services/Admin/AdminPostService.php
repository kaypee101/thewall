<?php

namespace App\Services\Admin;

use App\Repositories\PostRepository;
use App\Services\BaseService;

class AdminPostService extends BaseService
{
    protected $postRepository;

    /**
     * @param PostRepository $postRepository
     */
    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
        parent::__construct($postRepository);
    }
}
