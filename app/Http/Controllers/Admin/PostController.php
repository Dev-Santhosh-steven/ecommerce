<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display all blog posts.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(15);

        return view('admin.posts.index', compact('posts'));
    }


    /**
     * Show create post form.
     */
    public function create()
    {
        return view('admin.posts.create', ['post' => new Post(['author' => 'Yara Electronics'])]);
    }


    /**
     * Store new post.
     */
    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('blog', 'public');
        }

        Post::create($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Blog post created successfully.');
    }


    /**
     * Show edit post form.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }


    /**
     * Update post.
     */
    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request, $post);

        if ($request->hasFile('cover_image')) {
            $this->deleteCover($post);
            $data['cover_image'] = $request->file('cover_image')->store('blog', 'public');
        } elseif ($request->boolean('remove_cover_image')) {
            $this->deleteCover($post);
            $data['cover_image'] = null;
        }

        $post->update($data);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Blog post updated successfully.');
    }


    /**
     * Delete post.
     */
    public function destroy(Post $post)
    {
        $this->deleteCover($post);

        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Blog post deleted successfully.');
    }


    /**
     * Upload an image dropped into the content editor.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
        ]);

        $path = $request->file('file')->store('blog/content', 'public');

        // Relative URL so post content keeps working when the domain changes.
        return response()->json(['url' => '/storage/' . $path]);
    }


    private function validated(Request $request, ?Post $post = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'alpha_dash'],
            'category' => ['nullable', 'string', 'max:100'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'cover_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'author' => ['nullable', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        unset($validated['cover_image']);

        return [
            ...$validated,
            'slug' => $validated['slug'] ?? null,
            'is_published' => $request->boolean('is_published'),
            'published_at' => $validated['published_at'] ?? $post?->published_at,
        ];
    }


    private function deleteCover(Post $post): void
    {
        if ($post->cover_image) {
            Storage::disk('public')->delete($post->cover_image);
        }
    }
}
