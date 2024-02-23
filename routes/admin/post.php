<?php

use App\Http\Controllers\Admin\AdminPostController;
use Illuminate\Support\Facades\Route;

Route::resource('posts', AdminPostController::class)->parameters([
    'posts' => 'postId',
]);
