<?php
// app/Http/Controllers/PostController.php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $posts = $request->user()->posts()
            ->when($request->filled('q'), fn ($q) => $q->where('title', 'like', '%' . $request->q . '%'))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create', ['post' => new Post(['status' => 'draft'])]);
    }

    public function store(PostRequest $request)
    {
        $post = $request->user()->posts()->create(
            $this->withPublishDate($request->validated())
        );

        return redirect()->route('posts.show', $post)->with('status', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        Gate::authorize('view', $post);

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        return view('posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        Gate::authorize('update', $post);

        $post->update($this->withPublishDate($request->validated(), $post));

        return redirect()->route('posts.show', $post)->with('status', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return redirect()->route('posts.index')->with('status', 'Post deleted.');
    }

    private function withPublishDate(array $data, ?Post $post = null): array
    {
        $data['published_at'] = $data['status'] === 'published'
            ? ($post?->published_at ?? now())
            : null;

        return $data;
    }
}