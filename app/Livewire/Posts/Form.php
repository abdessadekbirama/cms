<?php
// app/Livewire/Posts/Form.php
// Handles both create and edit.

namespace App\Livewire\Posts;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Form extends Component
{
    public ?Post $post = null;

    public string $title = '';
    public string $slug = '';
    public string $excerpt = '';
    public string $body = '';
    public string $status = 'draft';

    public function mount(?Post $post = null): void
    {
        if ($post && $post->exists) {
            abort_unless($post->user_id === auth()->id(), 403);

            $this->post = $post;
            $this->title = $post->title;
            $this->slug = $post->slug;
            $this->excerpt = $post->excerpt ?? '';
            $this->body = $post->body;
            $this->status = $post->status;
        }
    }

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => [
                'required', 'string', 'max:255', 'alpha_dash',
                Rule::unique('posts', 'slug')->ignore($this->post?->id),
            ],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ];
    }

    // Auto-generate slug from title (only while creating)
    public function updatedTitle(string $value): void
    {
        if (! $this->post?->exists) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $data = $this->validate();

        $data['published_at'] = $data['status'] === 'published'
            ? ($this->post?->published_at ?? now())
            : null;

        if ($this->post?->exists) {
            $this->post->update($data);
            $message = 'Post updated.';
        } else {
            auth()->user()->posts()->create($data);
            $message = 'Post created.';
        }

        session()->flash('status', $message);

        return $this->redirectRoute('posts.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.posts.form');
    }
}