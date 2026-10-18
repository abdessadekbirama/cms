<?php
// app/Livewire/Posts/Index.php

namespace App\Livewire\Posts;

use App\Models\Post;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $status = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function togglePublish(int $id): void
    {
        $post = Post::where('user_id', auth()->id())->findOrFail($id);

        if ($post->isPublished()) {
            $post->update(['status' => 'draft']);
        } else {
            $post->update([
                'status' => 'published',
                'published_at' => $post->published_at ?? now(),
            ]);
        }
    }

    public function delete(int $id): void
    {
        Post::where('user_id', auth()->id())->findOrFail($id)->delete();

        session()->flash('status', 'Post deleted.');
    }

    public function render()
    {
        $posts = Post::where('user_id', auth()->id())
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->status, fn($q) => $q->where('status', $this->status))
            ->latest()
            ->paginate(10);

        return view('livewire.posts.index', ['posts' => $posts]);
    }
}
