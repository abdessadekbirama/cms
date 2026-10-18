{{-- resources/views/posts/create.blade.php --}}
<x-layouts.app title="New post">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10">

        <x-ui.button :href="route('posts.index')" variant="ghost" size="sm" icon="arrow-left" class="mb-4 -ml-3">
            Back to posts
        </x-ui.button>

        <x-ui.page-header title="New post" description="Write something great." />

        @include('posts._form', [
            'post' => $post,
            'action' => route('posts.store'),
            'submit' => 'Create post',
        ])
    </div>
</x-layouts.app>