<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');

        $posts = Post::published()
            ->when($category, fn ($query) => $query->where('category', $category))
            ->paginate(9)
            ->withQueryString();

        $categories = Post::published()
            ->whereNotNull('category')
            ->reorder()
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('store.blog.index', compact('posts', 'categories', 'category'));
    }

    public function show(Post $post)
    {
        abort_unless($post->isLive(), 404);

        $related = Post::published()
            ->whereKeyNot($post->id)
            ->limit(3)
            ->get();

        return view('store.blog.show', compact('post', 'related'));
    }
}
