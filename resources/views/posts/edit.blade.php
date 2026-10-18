{{-- resources/views/posts/edit.blade.php --}}
<x-layouts.app title="Edit post">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">

        <x-ui.button :href="route('posts.index')" variant="ghost" size="sm" icon="arrow-left" class="mb-4 -ml-3">
            Back to posts
        </x-ui.button>

        <x-ui.page-header title="Edit post" :description="'Last updated ' . $post->updated_at->diffForHumans()">
            <x-slot:actions>
                <x-ui.button :href="route('posts.show', $post)" variant="secondary" icon="eye">View</x-ui.button>
            </x-slot:actions>
        </x-ui.page-header>

        @include('posts._form', [
            'post' => $post,
            'action' => route('posts.update', $post),
            'submit' => 'Update post',
        ])
    </div>
</x-layouts.app>