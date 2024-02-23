<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    const TITLE = 'Post';

    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
    ];

    public static $select = [
        'id',
        'title',
        'slug',
    ];

    public static function boot()
    {
        parent::boot();

        self::saving(function ($post) {
            $post->slug = Str::slug($post->title);
        });
    }
}
